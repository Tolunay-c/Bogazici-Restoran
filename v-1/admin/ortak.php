<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   Admin — ortak katman
   - İmzalı çerezle oturum kontrolü yapar
   - CSRF token üretir/doğrular
   - Veri okuma/yazma (Upstash Redis varsa orası, yoksa veri.json)
   -------------------------------------------------------------- */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/mesaj.php';

/* Oturum: session yok, imzalı çerez (Vercel'de serverless örnekler arası kalıcı). */
function admin_gizli(): string
{
    $g = getenv('ADMIN_SECRET');
    if (is_string($g) && $g !== '') {
        return $g;
    }
    // Sunucuya özel rastgele anahtar (data/admin.php); yoksa son çare olarak hash'ten türetilir
    $g = (string) (admin_ayar()['gizli'] ?? '');
    if ($g !== '') {
        return $g;
    }
    return hash('sha256', admin_ayar()['parola_hash'] . '|bgz');
}

function guvenli_baglanti(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
}

function b64url_kodla(string $s): string
{
    return rtrim(strtr(base64_encode($s), '+/', '-_'), '=');
}

function b64url_coz(string $s): string
{
    return (string) base64_decode(strtr($s, '-_', '+/'), true);
}

function admin_cerez_yaz(string $ad, string $deger, int $bitis): void
{
    setcookie($ad, $deger, [
        'expires'  => $bitis,
        'path'     => '/',
        'secure'   => guvenli_baglanti(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

function admin_giris_yap(string $kullanici): void
{
    $bitis = time() + (int) admin_ayar()['oturum_omru'];
    $yuk = b64url_kodla($kullanici . '|' . $bitis);
    $imza = hash_hmac('sha256', $yuk, admin_gizli());
    admin_cerez_yaz('bgz_admin', $yuk . '.' . $imza, $bitis);
    $_COOKIE['bgz_admin'] = $yuk . '.' . $imza;
}

function admin_cikis_yap(): void
{
    admin_cerez_yaz('bgz_admin', '', time() - 42000);
    unset($_COOKIE['bgz_admin']);
}

/* CSRF (double-submit): çerezdeki rastgele değer + HMAC ile imzalı form token'ı */
if (empty($_COOKIE['bgz_csrf']) || !is_string($_COOKIE['bgz_csrf'])) {
    $_COOKIE['bgz_csrf'] = bin2hex(random_bytes(16));
    if (!headers_sent()) {
        admin_cerez_yaz('bgz_csrf', $_COOKIE['bgz_csrf'], 0);
    }
}

/* Demo modu: giriş dışındaki tüm POST'lar (kaydet/yükle/sil) işlenmeden geri döner.
   Mesaj query ile taşınır (oturum/depo gerektirmez). */
if (DEMO_MODU && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $yol = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/admin/', PHP_URL_PATH);
    if (!str_ends_with($yol, '/giris.php')) {
        $sorgu = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);
        parse_str($sorgu, $p);
        $p['demo'] = '1';
        header('Location: ' . $yol . '?' . http_build_query($p), true, 303);
        exit;
    }
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
    $c = $_COOKIE['bgz_admin'] ?? '';
    if (!is_string($c) || substr_count($c, '.') !== 1) {
        return false;
    }
    [$yuk, $imza] = explode('.', $c);
    if (!hash_equals(hash_hmac('sha256', $yuk, admin_gizli()), $imza)) {
        return false;
    }
    $parca = explode('|', b64url_coz($yuk));
    return count($parca) === 2 && $parca[0] === admin_ayar()['kullanici'] && (int) $parca[1] > time();
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
    return hash_hmac('sha256', (string) $_COOKIE['bgz_csrf'], admin_gizli());
}

function csrf_dogrula(): void
{
    $gelen = (string) ($_POST['csrf'] ?? '');
    if (!hash_equals(csrf_token(), $gelen)) {
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
    $depo = depo_veri_oku();
    if ($depo !== null) {
        return $depo;
    }
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
    // Boş/geçersiz slug'lı "hayalet" sayfa girdileri hiçbir URL'e bağlı
    // değildir; admin arayüzünde yanlışlıkla açılıp kaydedilebiliyorlar
    // ama siteye hiç yansımıyorlar. Her yazımda temizle.
    if (isset($veri['sayfalar']) && is_array($veri['sayfalar'])) {
        unset($veri['sayfalar']['']);
    }

    if (depo_kv_aktif()) {
        return depo_veri_yaz($veri);
    }

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

/**
 * Görsel kütüphanesi (ayrıntılı). Her öğe:
 *   deger  → veriye yazılan değer (paket: dosya adı, blob: tam URL)
 *   ad     → görünen dosya adı
 *   url    → önizleme adresi
 *   kaynak → 'paket' (assets/img) | 'blob' (Vercel Blob)
 * Blob açıkken paket görselleri salt okunurdur (silinemez/türevlenemez).
 */
function gorsel_listesi_detay(): array
{
    $turevDeseni = '/-(?:480|960|1440|2200)\.[a-z0-9]+$/i';
    $paket = [];
    $dizin = gorsel_dizin();
    if (is_dir($dizin)) {
        foreach (scandir($dizin) ?: [] as $ad) {
            if ($ad === '.' || $ad === '..') continue;
            if (!is_file($dizin . '/' . $ad)) continue;
            if (!preg_match('/\.(jpe?g|png|webp|gif|svg)$/i', $ad)) continue;
            // türev dosyaları (X-480.webp, X-960.webp gibi) listede saklama
            if (preg_match($turevDeseni, $ad)) continue;
            $paket[] = ['deger' => $ad, 'ad' => $ad, 'url' => gorsel_url($ad), 'kaynak' => 'paket'];
        }
    }

    $blob = [];
    if (blob_aktif()) {
        foreach (blob_listele('img/') as $b) {
            if (!preg_match('/\.(jpe?g|png|webp|gif)$/i', $b['pathname'])) continue;
            if (preg_match($turevDeseni, $b['pathname'])) continue;
            $blob[] = ['deger' => $b['url'], 'ad' => basename($b['pathname']), 'url' => $b['url'], 'kaynak' => 'blob'];
        }
    }

    $hepsi = array_merge($paket, $blob);
    usort($hepsi, fn($a, $b) => strnatcasecmp($a['ad'], $b['ad']));
    return $hepsi;
}

/** Seçici/önizleme için değer listesi (paket: dosya adı, blob: tam URL). */
function gorsel_listesi(): array
{
    return array_column(gorsel_listesi_detay(), 'deger');
}

/**
 * Yüklenen görseli doğrular, saklar ve responsive türevlerini üretir.
 * - Blob kapalı: assets/img'ye yazar; deger = dosya adı.
 * - Blob açık:   ad'a zaman damgası ekler (CDN önbelleği), orijinal + 4 türevi
 *                Blob'a yükler; deger = orijinalin tam URL'si.
 * $tabanAd: dosya adı tabanı (boşsa yüklenen dosyanın adı). $uzerineYaz yalnız dosya modunda anlamlı.
 */
function gorsel_yukle_isle(string $tmpYol, string $orijinalAd, string $tabanAd, bool $uzerineYaz): array
{
    $hata = fn(string $m) => ['ok' => false, 'deger' => '', 'mesaj' => $m];
    $blob = blob_aktif();

    $uzanti = strtolower((string) pathinfo($orijinalAd, PATHINFO_EXTENSION));
    if (!in_array($uzanti, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
        return $hata('Desteklenmeyen format. İzinli: jpg, jpeg, png, webp, gif');
    }
    $boyut = (int) @filesize($tmpYol);
    if ($blob && $boyut > 4 * 1024 * 1024) {
        return $hata('Görsel en fazla 4 MB olabilir.');
    }
    if (!$blob && $boyut > 8 * 1024 * 1024) {
        return $hata('Görsel çok büyük (max 8 MB).');
    }
    if (function_exists('mime_content_type')) {
        $mime = mime_content_type($tmpYol) ?: '';
        if (!str_starts_with($mime, 'image/')) {
            return $hata('Dosya geçerli bir görsel değil.');
        }
    }

    if ($tabanAd === '') $tabanAd = pathinfo($orijinalAd, PATHINFO_FILENAME);
    $slug = trim((string) preg_replace('/[^a-z0-9-]+/', '-', mb_strtolower($tabanAd)), '-');
    $slug = (string) preg_replace('/-\d{14}$/', '', $slug); // önceki zaman damgasını biriktirme
    if ($slug === '') $slug = 'gorsel-' . date('Ymd-His');

    if (!$blob) {
        $hedef = gorsel_dizin() . '/' . $slug . '.' . $uzanti;
        if (is_file($hedef)) {
            if ($uzerineYaz) {
                @unlink($hedef);
            } else {
                $hedef = gorsel_dizin() . '/' . $slug . '-' . date('YmdHis') . '.' . $uzanti;
            }
        }
        if (!move_uploaded_file($tmpYol, $hedef)) {
            return $hata('Diske yazma başarısız (assets/img yazılabilir mi?).');
        }
        gorsel_turevlerini_uret($hedef);   // -480/-960/-1440/-2200 türevleri
        return ['ok' => true, 'deger' => basename($hedef), 'mesaj' => 'Yüklendi: ' . basename($hedef)];
    }

    // Blob modu
    $slug .= '-' . date('YmdHis');
    $gecici = sys_get_temp_dir() . '/bgz-' . bin2hex(random_bytes(6)) . '.' . $uzanti;
    if (!move_uploaded_file($tmpYol, $gecici)) {
        return $hata('Geçici dosyaya yazma başarısız.');
    }
    gorsel_turevlerini_uret($gecici);

    $tipler = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'gif' => 'image/gif'];
    $ct = $tipler[$uzanti];
    $tmpAd = pathinfo($gecici, PATHINFO_FILENAME);
    $tmpDizin = dirname($gecici);

    $yuklenen = [];
    $anaUrl = blob_yukle($gecici, "img/{$slug}.{$uzanti}", $ct);
    $basarili = $anaUrl !== null;
    if ($basarili) {
        $yuklenen[] = $anaUrl;
        foreach (GORSEL_TUREVLERI as $g) {
            $u = blob_yukle("{$tmpDizin}/{$tmpAd}-{$g}.{$uzanti}", "img/{$slug}-{$g}.{$uzanti}", $ct);
            if ($u === null) { $basarili = false; break; }
            $yuklenen[] = $u;
        }
    }

    @unlink($gecici);
    foreach (GORSEL_TUREVLERI as $g) {
        @unlink("{$tmpDizin}/{$tmpAd}-{$g}.{$uzanti}");
    }

    if (!$basarili) {
        if ($yuklenen) blob_sil($yuklenen);
        return $hata('Görsel buluta yüklenemedi, lütfen tekrar deneyin.');
    }
    return ['ok' => true, 'deger' => $anaUrl, 'mesaj' => 'Yüklendi: ' . $slug . '.' . $uzanti];
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
        'kvkk'        => 'KVKK Aydınlatma Metni',
        'gizlilik'    => 'Gizlilik Politikası',
        'cerez'       => 'Çerez Aydınlatma Metni',
        'ik'          => 'İnsan Kaynakları',
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
        'harita'           => 'Harita (tekli)',
        'harita-sekmeli'   => 'Harita (sekmeli)',
        'zaman-cizelgesi'  => 'Zaman Çizelgesi',
        'sube-iletisim'    => 'Şube Kartları (İletişim)',
        'genel-iletisim'   => 'Genel İletişim Şeridi',
        'belge'            => 'Belge Metni (KVKK/Gizlilik vb.)',
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
        'telefon'        => 'Telefon (tel: link)',
        'telefon_yazi'   => 'Telefon (gösterim)',
        'eposta'         => 'E-posta',
        'guncelleme'     => 'Son Güncelleme Tarihi',
        'bolumler'       => 'Bölümler',
        'kimlik'         => 'Bağlantı Kimliği (id, opsiyonel)',
        'alinti'         => 'Alıntı / Slogan',
        'alt_not'        => 'Alt Not (küçük yazı)',
    ][$k] ?? ucfirst(str_replace('_', ' ', $k));
}
