<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/mesaj.php';

function rezervasyon_yonlendir(string $sube = '', string $durum = ''): never
{
    $sorgu = [];
    if ($sube !== '') {
        $sorgu['sube'] = $sube;
    }
    if ($durum !== '') {
        $sorgu['form'] = $durum;
    }
    $adres = '/rezervasyon.php' . ($sorgu ? '?' . http_build_query($sorgu) : '') . ($durum !== '' ? '#rezervasyon-form' : '');
    header('Location: ' . $adres, true, 303);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    rezervasyon_yonlendir();
}

// Geçerli şube slug'ı (yönlendirmede korunur)
$subeSlug = trim((string) ($_POST['sube'] ?? ''));
$subeAd = '';
foreach (SUBELER as $s) {
    if (($s['slug'] ?? '') === $subeSlug) {
        $subeAd = (string) $s['ad'];
        break;
    }
}
$yonSube = $subeAd !== '' ? $subeSlug : '';

// Bot filtresi: bal küpü dolu ya da form 3 saniyeden kısa sürede gönderildi → sessizce "tamam"
$balKupu = trim((string) ($_POST['web_sitesi'] ?? ''));
$zaman = (int) ($_POST['zaman'] ?? 0);
if ($balKupu !== '' || $zaman <= 0 || (time() - $zaman) < 3) {
    rezervasyon_yonlendir($yonSube, 'tamam');
}

$tarihMetin = trim((string) ($_POST['tarih'] ?? ''));
$saat       = trim((string) ($_POST['saat'] ?? ''));
$kisiMetin  = trim((string) ($_POST['kisi'] ?? ''));
$ad         = trim((string) ($_POST['ad'] ?? ''));
$telefon    = trim((string) ($_POST['telefon'] ?? ''));
$not        = trim((string) ($_POST['not'] ?? ''));
$kvkk       = !empty($_POST['kvkk']);

$tarih = DateTimeImmutable::createFromFormat('!Y-m-d', $tarihMetin);
$tarihHata = DateTimeImmutable::getLastErrors();
$tarihGecerli = $tarih !== false
    && ($tarihHata === false || ($tarihHata['warning_count'] === 0 && $tarihHata['error_count'] === 0))
    && $tarih->format('Y-m-d') === $tarihMetin;
if ($tarihGecerli) {
    $bugun = new DateTimeImmutable('today');
    $tarihGecerli = $tarih >= $bugun && $tarih <= $bugun->modify('+90 days');
}

$saatler = array_merge(...array_values(REZERVASYON_SAATLERI));
$kisi = ctype_digit($kisiMetin) ? (int) $kisiMetin : 0;

$gecerli = $subeAd !== ''
    && $tarihGecerli
    && in_array($saat, $saatler, true)
    && $kisi >= 1 && $kisi <= 12
    && mb_strlen($ad) >= 2 && mb_strlen($ad) <= 100
    && mb_strlen($telefon) >= 7 && mb_strlen($telefon) <= 30
    && preg_match('/^[0-9\s+()\-]+$/', $telefon) === 1
    && mb_strlen($not) <= 1000
    && $kvkk;

if (!$gecerli) {
    rezervasyon_yonlendir($yonSube, 'hata');
}

$tarihYazi = $tarih->format('d.m.Y');

$mailDurum = bildirim_maili_gonder(
    "Rezervasyon talebi — {$subeAd} · {$tarihYazi} {$saat} · {$kisi} kişi",
    "Şube: {$subeAd}\nTarih: {$tarihYazi}\nSaat: {$saat}\nKişi: {$kisi}\nAd: {$ad}\nTelefon: {$telefon}\nNot: " . ($not !== '' ? $not : '-')
        . "\n\nGönderim zamanı: " . date('d.m.Y H:i') . "\n"
);

$kayitId = mesaj_ekle([
    'tur'       => 'rezervasyon',
    'sube'      => $subeSlug,
    'sube_ad'   => $subeAd,
    'rez_tarih' => $tarihMetin,
    'saat'      => $saat,
    'kisi'      => $kisi,
    'ad'        => $ad,
    'telefon'   => $telefon,
    'not'       => $not,
    'mail'      => $mailDurum,
]);
mail_log_yaz('rezervasyon', $mailDurum, (string) $kayitId);

rezervasyon_yonlendir($subeSlug, $kayitId !== null || $mailDurum === 'gonderildi' ? 'tamam' : 'hata');
