<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   Admin — ortak katman
   - Session başlatır, oturum kontrolü yapar
   - CSRF token üretir/doğrular
   - Veri okuma/yazma (veri.json)
   -------------------------------------------------------------- */

require_once __DIR__ . '/../config.php';

/* Session */
if (session_status() === PHP_SESSION_NONE) {
    $ayar = require __DIR__ . '/../data/admin.php';
    session_set_cookie_params([
        'lifetime' => $ayar['oturum_omru'],
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function admin_ayar(): array
{
    static $ayar = null;
    if ($ayar === null) {
        $ayar = require __DIR__ . '/../data/admin.php';
    }
    return $ayar;
}

function admin_giris_yapmis(): bool
{
    return !empty($_SESSION['admin_kullanici']);
}

function admin_zorunlu(): void
{
    if (!admin_giris_yapmis()) {
        header('Location: /admin/giris.php');
        exit;
    }
}

/* CSRF */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(24));
    }
    return $_SESSION['csrf'];
}

function csrf_dogrula(): void
{
    $gelen = (string) ($_POST['csrf'] ?? '');
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $gelen)) {
        http_response_code(400);
        exit('Güvenlik doğrulaması başarısız — sayfayı yenileyip tekrar deneyin.');
    }
}

/* Veri katmanı */
function veri_yolu(): string
{
    return __DIR__ . '/../data/veri.json';
}

function veri_oku(): array
{
    $y = veri_yolu();
    if (is_file($y)) {
        $d = json_decode((string) file_get_contents($y), true);
        if (is_array($d) && isset($d['subeler'], $d['sayfalar'])) {
            return $d;
        }
    }
    return require __DIR__ . '/../data/varsayilan.php';
}

function veri_yaz(array $veri): bool
{
    $y = veri_yolu();
    $yedek = $y . '.yedek';
    if (is_file($y)) {
        @copy($y, $yedek);
    }
    $json = json_encode($veri, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    return (bool) file_put_contents($y, $json, LOCK_EX);
}

/* Görsel dizini */
function gorsel_dizin(): string
{
    return realpath(__DIR__ . '/../assets/img') ?: (__DIR__ . '/../assets/img');
}

/**
 * Yüklenen bir görsel için responsive türevleri üretir (480/960/1440/2200).
 * GD eklentisi varsa yeniden boyutlandırır; yoksa aynı dosyayı kopyalar (fallback).
 * $kaynak: assets/img altındaki tam yol.
 */
function gorsel_turevlerini_uret(string $kaynak): void
{
    if (!is_file($kaynak)) return;

    $uzanti = strtolower((string) pathinfo($kaynak, PATHINFO_EXTENSION));
    $ad     = pathinfo($kaynak, PATHINFO_FILENAME);
    $dizin  = dirname($kaynak);
    $boyutlar = [480, 960, 1440, 2200];

    $gdVar = extension_loaded('gd');
    $src = null;
    $srcEn = 0; $srcBoy = 0;

    if ($gdVar) {
        switch ($uzanti) {
            case 'jpg': case 'jpeg':
                $src = @imagecreatefromjpeg($kaynak); break;
            case 'png':
                $src = @imagecreatefrompng($kaynak); break;
            case 'webp':
                $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($kaynak) : null; break;
            case 'gif':
                $src = @imagecreatefromgif($kaynak); break;
        }
        if ($src) {
            $srcEn = imagesx($src);
            $srcBoy = imagesy($src);
        }
    }

    foreach ($boyutlar as $en) {
        $hedef = "{$dizin}/{$ad}-{$en}.{$uzanti}";
        if ($src && $srcEn > 0) {
            // Kaynağın gerçek genişliği hedefin altındaysa yeniden büyütmüyoruz — kopya.
            if ($srcEn <= $en) {
                @copy($kaynak, $hedef);
                continue;
            }
            $oran = $srcBoy / $srcEn;
            $yeniBoy = (int) round($en * $oran);
            $img = imagecreatetruecolor($en, $yeniBoy);
            if (in_array($uzanti, ['png', 'webp', 'gif'], true)) {
                imagealphablending($img, false);
                imagesavealpha($img, true);
                $seffaf = imagecolorallocatealpha($img, 0, 0, 0, 127);
                imagefill($img, 0, 0, $seffaf);
            }
            imagecopyresampled($img, $src, 0, 0, 0, 0, $en, $yeniBoy, $srcEn, $srcBoy);
            switch ($uzanti) {
                case 'jpg': case 'jpeg':
                    imagejpeg($img, $hedef, 82); break;
                case 'png':
                    imagepng($img, $hedef, 6); break;
                case 'webp':
                    if (function_exists('imagewebp')) imagewebp($img, $hedef, 82);
                    else @copy($kaynak, $hedef);
                    break;
                case 'gif':
                    imagegif($img, $hedef); break;
            }
            imagedestroy($img);
        } else {
            // GD yoksa aynı dosyayı türev adıyla kopyala — frontend'in bulmasına yeter.
            @copy($kaynak, $hedef);
        }
    }

    if ($src) imagedestroy($src);
}

function gorsel_listesi(): array
{
    $dizin = gorsel_dizin();
    if (!is_dir($dizin)) return [];
    $sonuc = [];
    foreach (scandir($dizin) ?: [] as $ad) {
        if ($ad === '.' || $ad === '..') continue;
        if (!is_file($dizin . '/' . $ad)) continue;
        if (!preg_match('/\.(jpe?g|png|webp|gif|svg)$/i', $ad)) continue;
        // türev dosyaları (X-480.webp, X-960.webp gibi) listede saklama
        if (preg_match('/-(?:480|960|1440|2200)\.[a-z]+$/i', $ad)) continue;
        $sonuc[] = $ad;
    }
    sort($sonuc, SORT_NATURAL | SORT_FLAG_CASE);
    return $sonuc;
}

/* Yardımcı: e() zaten fonksiyonlar.php'de var (config -> fonksiyonlar) */

/* Sayfa etiketleri */
function sayfa_etiket(string $slug): string
{
    return [
        'anasayfa'    => 'Ana Sayfa',
        'kurumsal'    => 'Kurumsal',
        'subeler'     => 'Şubeler Sayfası',
        'menu'        => 'Menü',
        'hizmetler'   => 'Hizmetler',
        'galeri'      => 'Galeri',
        'rezervasyon' => 'Rezervasyon',
        'iletisim'    => 'İletişim',
    ][$slug] ?? ucfirst($slug);
}

/**
 * Bir görsel dosyasının hangi slot'larda kullanıldığını haritalar.
 * Dönüş: [ 'hero-anasayfa.webp' => [ ['yer' => 'Ana Sayfa · Hero · gorsel', 'link' => '/admin/sayfa.php?ad=anasayfa'], ... ], ... ]
 */
function gorsel_kullanimlari(array $veri): array
{
    $harita = [];
    $goruldu = []; // aynı yer+dosya çiftini iki kez eklememek için

    $ekle = function (string $dosya, array $kayit) use (&$harita, &$goruldu): void {
        $imza = $dosya . '|' . ($kayit['yer'] ?? '');
        if (isset($goruldu[$imza])) return;
        $goruldu[$imza] = true;
        $harita[$dosya][] = $kayit;
    };

    foreach (($veri['sayfalar'] ?? []) as $sayfa => $bolumler) {
        if (!is_array($bolumler)) continue;
        foreach ($bolumler as $i => $b) {
            if (!is_array($b)) continue;
            $tip = (string) ($b['tip'] ?? '');
            $tipAd = bolum_tip_etiket($tip);
            $baslikIpucu = (string) ($b['baslik'] ?? $b['ustluk'] ?? '');
            $bolumEtiket = $baslikIpucu !== '' ? "\"{$baslikIpucu}\"" : "#" . ($i + 1);
            $link = '/admin/sayfa.php?ad=' . rawurlencode($sayfa);
            $onEk = sayfa_etiket($sayfa) . ' · ' . $tipAd . ' ' . $bolumEtiket;

            foreach (['gorsel', 'gorsel_mobil'] as $alan) {
                if (!empty($b[$alan]) && is_string($b[$alan])) {
                    $ekle($b[$alan], [
                        'yer'   => $onEk . ' · ' . $alan,
                        'link'  => $link,
                        'sayfa' => $sayfa, 'bolum' => $i, 'alan' => $alan,
                    ]);
                }
            }
            if (!empty($b['ogeler']) && is_array($b['ogeler'])) {
                foreach ($b['ogeler'] as $oi => $oge) {
                    if (!is_array($oge) || empty($oge['gorsel'])) continue;
                    $ekle($oge['gorsel'], [
                        'yer'   => $onEk . ' · öge ' . ($oi + 1),
                        'link'  => $link,
                        'sayfa' => $sayfa, 'bolum' => $i, 'alan' => 'ogeler[' . $oi . '][gorsel]',
                    ]);
                }
            }
        }
    }

    foreach (($veri['subeler'] ?? []) as $s) {
        if (!is_array($s) || empty($s['gorsel'])) continue;
        $ekle($s['gorsel'], [
            'yer'  => 'Şube · ' . ($s['ad'] ?? $s['slug'] ?? ''),
            'link' => '/admin/sube.php?slug=' . rawurlencode((string) ($s['slug'] ?? '')),
            'sube' => (string) ($s['slug'] ?? ''),
        ]);
    }

    return $harita;
}

/**
 * Görsel yüklemek için tüm slot listesi (hedef atama dropdown'ı).
 * Dönüş: [ 'anasayfa|0|gorsel' => 'Ana Sayfa · Hero "..." · gorsel', ... ]
 */
function gorsel_slotlari(array $veri): array
{
    $slotlar = [];
    foreach (($veri['sayfalar'] ?? []) as $sayfa => $bolumler) {
        if (!is_array($bolumler)) continue;
        foreach ($bolumler as $i => $b) {
            if (!is_array($b)) continue;
            $tip = (string) ($b['tip'] ?? '');
            $tipAd = bolum_tip_etiket($tip);
            $baslik = (string) ($b['baslik'] ?? $b['ustluk'] ?? '');
            $etiketBase = sayfa_etiket($sayfa) . ' · ' . $tipAd . ($baslik !== '' ? " \"{$baslik}\"" : '');

            foreach (['gorsel', 'gorsel_mobil'] as $alan) {
                if (array_key_exists($alan, $b)) {
                    $anahtar = "sayfa|{$sayfa}|{$i}|{$alan}";
                    $slotlar[$anahtar] = $etiketBase . ' · ' . $alan;
                }
            }
            if (!empty($b['ogeler']) && is_array($b['ogeler'])) {
                foreach ($b['ogeler'] as $oi => $oge) {
                    if (!is_array($oge) || !array_key_exists('gorsel', $oge)) continue;
                    $anahtar = "sayfa|{$sayfa}|{$i}|ogeler|{$oi}|gorsel";
                    $slotlar[$anahtar] = $etiketBase . ' · öge ' . ($oi + 1);
                }
            }
        }
    }
    foreach (($veri['subeler'] ?? []) as $s) {
        if (!is_array($s)) continue;
        $slug = (string) ($s['slug'] ?? '');
        if ($slug === '') continue;
        $slotlar["sube|{$slug}|gorsel"] = 'Şube · ' . ($s['ad'] ?? $slug);
    }
    return $slotlar;
}

/**
 * Verilen slot anahtarına dosya adını atar (veri.json güncellenir).
 * $anahtar: gorsel_slotlari() key'i.
 * Başarılı ise true.
 */
function slot_atama_yap(string $anahtar, string $dosyaAdi): bool
{
    $parca = explode('|', $anahtar);
    $veri  = veri_oku();

    if ($parca[0] === 'sayfa') {
        // sayfa|<ad>|<index>|<alan>  veya  sayfa|<ad>|<index>|ogeler|<oi>|gorsel
        [$_, $ad, $idx] = $parca;
        $idx = (int) $idx;
        if (!isset($veri['sayfalar'][$ad][$idx])) return false;
        if (count($parca) === 4) {
            $veri['sayfalar'][$ad][$idx][$parca[3]] = $dosyaAdi;
        } elseif (count($parca) === 6 && $parca[3] === 'ogeler') {
            $oi = (int) $parca[4];
            if (!isset($veri['sayfalar'][$ad][$idx]['ogeler'][$oi])) return false;
            $veri['sayfalar'][$ad][$idx]['ogeler'][$oi]['gorsel'] = $dosyaAdi;
        } else {
            return false;
        }
    } elseif ($parca[0] === 'sube') {
        [$_, $slug] = $parca;
        $bulundu = false;
        foreach ($veri['subeler'] as $i => $s) {
            if (($s['slug'] ?? '') === $slug) {
                $veri['subeler'][$i]['gorsel'] = $dosyaAdi;
                $bulundu = true;
                break;
            }
        }
        if (!$bulundu) return false;
    } else {
        return false;
    }

    return veri_yaz($veri);
}

function bolum_tip_etiket(string $tip): string
{
    return [
        'hero'             => 'Hero (Kapak)',
        'metin-gorsel'     => 'Metin + Görsel',
        'menu-vitrin'      => 'Menü Vitrini',
        'sube-listesi'     => 'Şube Listesi',
        'rakamlar'         => 'Rakamlar',
        'galeri-onizleme'  => 'Galeri Önizleme',
        'rezervasyon-blok' => 'Rezervasyon Bloğu',
        'sss'              => 'Sık Sorulanlar',
        'kart-izgara'      => 'Kart Izgarası',
        'cta-bant'         => 'CTA Bandı',
        'sayfa-basligi'    => 'Sayfa Başlığı',
        'menu-liste'       => 'Menü Listesi',
        'iletisim'         => 'İletişim Bloğu',
        'rezervasyon-akis' => 'Rezervasyon Akışı',
    ][$tip] ?? $tip;
}

/** Form alan anahtarını Türkçe etiketine çevirir (admin form alanları için). */
function alan_etiket(string $k): string
{
    return [
        'ustluk'         => 'Üst Başlık',
        'baslik'         => 'Başlık',
        'alt_baslik'     => 'Alt Başlık',
        'metin'          => 'Metin',
        'yon'            => 'Yön',
        'zemin'          => 'Zemin',
        'kirp'           => 'Görseli Kırp',
        'buton_yazi'     => 'Buton Yazısı',
        'buton_link'     => 'Buton Bağlantısı',
        'buton2_yazi'    => 'İkinci Buton Yazısı',
        'buton2_link'    => 'İkinci Buton Bağlantısı',
        'gorsel'         => 'Görsel',
        'gorsel_mobil'   => 'Mobil Görsel',
        'gorsel_odak'    => 'Görsel Odağı',
        'gorsel_alt'     => 'Görsel Açıklaması (alt)',
        'en'             => 'Genişlik',
        'boy'            => 'Yükseklik',
        'duzen'          => 'Düzen',
        'on_secili_sube' => 'Ön Seçili Şube',
        'ogeler'         => 'Öğeler',
        'kategoriler'    => 'Kategoriler',
        'etiket'         => 'Etiket',
        'sayi'           => 'Sayı',
        'aciklama'       => 'Açıklama',
        'not'            => 'Not',
        'link'           => 'Bağlantı',
        'ad'             => 'Ad',
        'fiyat'          => 'Fiyat',
        'ozet'           => 'Özet',
    ][$k] ?? ucfirst(str_replace('_', ' ', $k));
}
