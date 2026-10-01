<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   MESAJ DEPOSU — iletişim formu mesajları
   Redis varsa orada, yoksa data/mesajlar.json dosyasında tutulur.
   KVKK: IP ve tarayıcı bilgisi SAKLANMAZ.
   -------------------------------------------------------------- */

require_once __DIR__ . '/depo.php';

const MESAJ_ANAHTAR = 'bogazici:mesajlar';
const MESAJ_EN_FAZLA = 500;

function mesaj_dosya_yolu(): string
{
    return __DIR__ . '/../data/mesajlar.json';
}

/** Dönüş: mesaj listesi; kayıt yoksa []; okuma hatasında null (asla boş listeyle üzerine yazma). */
function mesajlar_oku(): ?array
{
    if (depo_kv_aktif()) {
        $y = depo_kv_istek('/get/' . MESAJ_ANAHTAR);
        if ($y === null) {
            return null;
        }
        if (($y['result'] ?? null) === null) {
            return [];
        }
        if (!is_string($y['result'])) {
            return null;
        }
        $d = json_decode($y['result'], true);
        return is_array($d) ? $d : null;
    }
    $yol = mesaj_dosya_yolu();
    if (!is_file($yol)) {
        return [];
    }
    $icerik = @file_get_contents($yol);
    if ($icerik === false) {
        return null;
    }
    $d = json_decode($icerik, true);
    return is_array($d) ? $d : null;
}

function mesajlar_yaz(array $liste): bool
{
    $liste = array_slice(array_values($liste), 0, MESAJ_EN_FAZLA);

    if (depo_kv_aktif()) {
        $json = json_encode($liste, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            return false;
        }
        $y = depo_kv_istek('/set/' . MESAJ_ANAHTAR, $json);
        return is_array($y) && ($y['result'] ?? null) === 'OK';
    }

    $json = json_encode($liste, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    if ($json === false) {
        return false;
    }
    return file_put_contents(mesaj_dosya_yolu(), $json, LOCK_EX) !== false;
}

/** Kaydı ekler; başarılıysa kayıt id'sini, değilse null döner. */
function mesaj_ekle(array $m): ?string
{
    $m['tur'] = $m['tur'] ?? 'iletisim';
    $m['id'] = bin2hex(random_bytes(6));
    $m['tarih'] = date('Y-m-d H:i');
    $m['okundu'] = false;
    $liste = mesajlar_oku();
    if ($liste === null) {
        return null;
    }
    array_unshift($liste, $m);
    return mesajlar_yaz($liste) ? $m['id'] : null;
}

function mesaj_okundu(string $id, bool $durum): bool
{
    $liste = mesajlar_oku();
    if ($liste === null) {
        return false;
    }
    $bulundu = false;
    foreach ($liste as $i => $m) {
        if (($m['id'] ?? '') === $id) {
            $liste[$i]['okundu'] = $durum;
            $bulundu = true;
            break;
        }
    }
    return $bulundu && mesajlar_yaz($liste);
}

function mesaj_sil(string $id): bool
{
    $liste = mesajlar_oku();
    if ($liste === null) {
        return false;
    }
    $yeni =array_values(array_filter($liste, static fn (array $m): bool => ($m['id'] ?? '') !== $id));
    return count($yeni) !== count($liste) && mesajlar_yaz($yeni);
}

function okunmamis_mesaj_sayisi(): int
{
    return count(array_filter(mesajlar_oku() ?? [],static fn (array $m): bool => empty($m['okundu'])));
}

/** Mail başlığına girecek değerden satır sonlarını temizler (header injection). */
function baslik_temizle(string $s): string
{
    return trim(str_replace(["\r", "\n"], ' ', $s));
}

/** Form bildirimini ILETISIM_EPOSTA adresine yollar. Adres boşsa ya da mail() başarısızsa false. */
/* --------------------------------------------------------------
   MAIL LOG — her form gönderiminde mail durumu data/mail.log'a yazılır.
   KVKK: isim/telefon/e-posta yazılmaz; yalnızca tarih, tür, durum, kayıt id.
   -------------------------------------------------------------- */

const MAIL_LOG_AZAMI = 512 * 1024; // aşınca mail.log.1'e devredilir

const MAIL_DURUM_ETIKETI = [
    'gonderildi'    => 'Sunucuya teslim edildi',
    'gonderilemedi' => 'Gönderilemedi',
    'kapali'        => 'Gönderilmedi (alıcı adresi yok / yerel ortam)',
];

function mail_log_yolu(): string
{
    return __DIR__ . '/../data/mail.log';
}

function mail_log_yaz(string $tur, string $durum, string $kayitId): void
{
    $satir = sprintf(
        "%s | %-11s | %-13s | %s | kayıt: %s\n",
        date('Y-m-d H:i:s'),
        $tur,
        $durum,
        ILETISIM_EPOSTA !== '' ? ILETISIM_EPOSTA : '-',
        $kayitId !== '' ? $kayitId : 'KAYDEDİLEMEDİ'
    );
    if (depo_kv_aktif()) {
        // Salt okunur dosya sistemi (Vercel): sunucu loguna yaz
        error_log('mail-log: ' . trim($satir));
        return;
    }
    $yol = mail_log_yolu();
    if (is_file($yol) && filesize($yol) > MAIL_LOG_AZAMI) {
        @rename($yol, $yol . '.1');
    }
    if (@file_put_contents($yol, $satir, FILE_APPEND | LOCK_EX) === false) {
        error_log('mail-log yazılamadı: ' . trim($satir));
    }
}

/** Son $adet satır, en yeni üstte. */
function mail_log_son(int $adet = 50): array
{
    $yol = mail_log_yolu();
    if (!is_file($yol)) {
        return [];
    }
    $satirlar = file($yol, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    return array_reverse(array_slice($satirlar, -$adet));
}

/** Dönüş: 'gonderildi' | 'gonderilemedi' | 'kapali' (alıcı adresi tanımlı değil). */
function bildirim_maili_gonder(string $konu, string $govde, string $yanitla = ''): string
{
    if (ILETISIM_EPOSTA === '') {
        return 'kapali';
    }
    $alan = strtolower((string) preg_replace('/:\d+$/', '', (string) ($_SERVER['HTTP_HOST'] ?? 'localhost')));
    $alan = baslik_temizle((string) preg_replace('/^www\./', '', $alan));

    $basliklar = [
        'From: no-reply@' . $alan,
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
    ];
    if ($yanitla !== '' && filter_var($yanitla, FILTER_VALIDATE_EMAIL) !== false) {
        $basliklar[] = 'Reply-To: ' . baslik_temizle($yanitla);
    }

    $gitti = @mail(
        baslik_temizle(ILETISIM_EPOSTA),
        mb_encode_mimeheader(baslik_temizle($konu), 'UTF-8'),
        $govde,
        implode("\r\n", $basliklar)
    );
    if (!$gitti) {
        error_log('bildirim_maili_gonder: mail() başarısız');
    }
    return $gitti ? 'gonderildi' : 'gonderilemedi';
}
