<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   DEPO KATMANI — Upstash Redis (REST)
   Ortam değişkenleri yoksa hiçbir şey yapmaz: site/admin dosyayla
   (data/veri.json) eskisi gibi çalışır.
   -------------------------------------------------------------- */

const DEPO_VERI_ANAHTAR = 'bogazici:veri';
const DEPO_VERI_YEDEK_ANAHTAR = 'bogazici:veri:yedek';

function depo_kv_ayar(): ?array
{
    $url = getenv('KV_REST_API_URL') ?: getenv('UPSTASH_REDIS_REST_URL');
    $token = getenv('KV_REST_API_TOKEN') ?: getenv('UPSTASH_REDIS_REST_TOKEN');
    if (!$url || !$token) {
        return null;
    }
    return ['url' => rtrim((string) $url, '/'), 'token' => (string) $token];
}

function depo_kv_aktif(): bool
{
    return depo_kv_ayar() !== null;
}

function depo_kv_istek(string $yol, ?string $govde = null): ?array
{
    $ayar = depo_kv_ayar();
    if ($ayar === null || !function_exists('curl_init')) {
        return null;
    }

    $ch = curl_init($ayar['url'] . $yol);
    $secenekler = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $ayar['token']],
    ];
    if ($govde !== null) {
        $secenekler[CURLOPT_POST] = true;
        $secenekler[CURLOPT_POSTFIELDS] = $govde;
    }
    curl_setopt_array($ch, $secenekler);

    $yanit = curl_exec($ch);
    $kod = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $hata = curl_error($ch);

    if ($yanit === false || $kod !== 200) {
        error_log('depo_kv_istek başarısız: ' . $yol . ' HTTP ' . $kod . ' ' . $hata);
        return null;
    }
    $d = json_decode((string) $yanit, true);
    return is_array($d) ? $d : null;
}

function depo_veri_oku(bool $yenile = false): ?array
{
    // İstek başına önbellek; depo_veri_yaz() başarılı olunca güncellenir
    if (!$yenile && array_key_exists('depo_veri_onbellek', $GLOBALS)) {
        return $GLOBALS['depo_veri_onbellek'];
    }
    $GLOBALS['depo_veri_onbellek'] = null;
    if (!depo_kv_aktif()) {
        return null;
    }
    $y = depo_kv_istek('/get/' . DEPO_VERI_ANAHTAR);
    if (is_array($y) && is_string($y['result'] ?? null)) {
        $d = json_decode($y['result'], true);
        if (is_array($d) && isset($d['subeler'], $d['sayfalar'])) {
            $GLOBALS['depo_veri_onbellek'] = $d;
        }
    }
    return $GLOBALS['depo_veri_onbellek'];
}

function depo_veri_yaz(array $veri): bool
{
    if (!depo_kv_aktif()) {
        return false;
    }
    $json = json_encode($veri, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    // Önce mevcut değeri yedeğe al
    $mevcut = depo_kv_istek('/get/' . DEPO_VERI_ANAHTAR);
    if (is_array($mevcut) && is_string($mevcut['result'] ?? null)) {
        depo_kv_istek('/set/' . DEPO_VERI_YEDEK_ANAHTAR, $mevcut['result']);
    }

    $y = depo_kv_istek('/set/' . DEPO_VERI_ANAHTAR, $json);
    $ok = is_array($y) && ($y['result'] ?? null) === 'OK';
    if ($ok) {
        $GLOBALS['depo_veri_onbellek'] = $veri;
    }
    return $ok;
}

/* --------------------------------------------------------------
   BLOB KATMANI — Vercel Blob (görseller)
   BLOB_READ_WRITE_TOKEN yoksa kapalıdır; görseller assets/img'de kalır.
   -------------------------------------------------------------- */

const BLOB_TABAN = 'https://blob.vercel-storage.com';
const BLOB_API_SURUMU = '7';

function blob_token(): ?string
{
    $t = getenv('BLOB_READ_WRITE_TOKEN');
    return is_string($t) && $t !== '' ? $t : null;
}

function blob_aktif(): bool
{
    return blob_token() !== null && function_exists('curl_init');
}

/** Ham Blob isteği. Dönüş: [http_kodu, govde_metni] (bağlantı hatasında [0, '']). */
function blob_istek(string $yontem, string $url, array $basliklar = [], ?string $govde = null): array
{
    $ch = curl_init($url);
    $h = array_merge([
        'Authorization: Bearer ' . blob_token(),
        'x-api-version: ' . BLOB_API_SURUMU,
    ], $basliklar);
    $secenek = [
        CURLOPT_CUSTOMREQUEST  => $yontem,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_HTTPHEADER     => $h,
    ];
    if ($govde !== null) {
        $secenek[CURLOPT_POSTFIELDS] = $govde;
    }
    curl_setopt_array($ch, $secenek);
    $yanit = curl_exec($ch);
    $kod = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return [$kod, $yanit === false ? '' : (string) $yanit];
}

function blob_yukle(string $yerelYol, string $pathname, string $contentType): ?string
{
    if (!blob_aktif() || !is_file($yerelYol)) {
        return null;
    }
    $icerik = file_get_contents($yerelYol);
    if ($icerik === false) {
        return null;
    }
    $basliklar = [
        'x-content-type: ' . $contentType,
        'x-add-random-suffix: 0',
        'x-allow-overwrite: 1',
        'x-cache-control-max-age: 31536000',
    ];
    // Canlıda doğrulanan biçim: PUT /<pathname>. "?pathname=" biçimi "Invalid pathname" (400) döndü.
    $adresler = [
        BLOB_TABAN . '/' . $pathname,
        BLOB_TABAN . '/?pathname=' . rawurlencode($pathname),
    ];
    foreach ($adresler as $adres) {
        [$kod, $yanit] = blob_istek('PUT', $adres, $basliklar, $icerik);
        if ($kod === 200) {
            $d = json_decode($yanit, true);
            if (is_array($d) && !empty($d['url'])) {
                return (string) $d['url'];
            }
        }
        error_log('blob_yukle başarısız: ' . $pathname . ' HTTP ' . $kod . ' ' . substr($yanit, 0, 200));
    }
    return null;
}

function blob_listele(string $onek): array
{
    if (!blob_aktif()) {
        return [];
    }
    $sonuc = [];
    $cursor = null;
    do {
        $adres = BLOB_TABAN . '?prefix=' . rawurlencode($onek) . '&limit=1000'
            . ($cursor ? '&cursor=' . rawurlencode($cursor) : '');
        [$kod, $yanit] = blob_istek('GET', $adres);
        $d = json_decode($yanit, true);
        if ($kod !== 200 || !is_array($d)) {
            error_log('blob_listele başarısız: HTTP ' . $kod . ' ' . substr($yanit, 0, 200));
            break;
        }
        foreach (($d['blobs'] ?? []) as $b) {
            $sonuc[] = [
                'url'        => (string) ($b['url'] ?? ''),
                'pathname'   => (string) ($b['pathname'] ?? ''),
                'size'       => (int) ($b['size'] ?? 0),
                'uploadedAt' => (string) ($b['uploadedAt'] ?? ''),
            ];
        }
        $cursor = !empty($d['hasMore']) && !empty($d['cursor']) ? (string) $d['cursor'] : null;
    } while ($cursor !== null);
    return $sonuc;
}

function blob_sil(array $urller): bool
{
    $urller = array_values(array_filter($urller, 'is_string'));
    if (!blob_aktif() || !$urller) {
        return false;
    }
    [$kod, $yanit] = blob_istek('POST', BLOB_TABAN . '/delete',
        ['Content-Type: application/json'], json_encode(['urls' => $urller]));
    if ($kod !== 200) {
        error_log('blob_sil başarısız: HTTP ' . $kod . ' ' . substr($yanit, 0, 200));
        return false;
    }
    return true;
}
