<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/mesaj.php';

function iletisim_yonlendir(string $durum = ''): void
{
    $adres = '/iletisim.php' . ($durum !== '' ? '?form=' . $durum . '#iletisim-form' : '');
    header('Location: ' . $adres, true, 303);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    iletisim_yonlendir();
}

// Bot filtresi: bal küpü dolu ya da form 3 saniyeden kısa sürede gönderildi → sessizce "tamam"
$balKupu = trim((string) ($_POST['web_sitesi'] ?? ''));
$zaman = (int) ($_POST['zaman'] ?? 0);
if ($balKupu !== '' || $zaman <= 0 || (time() - $zaman) < 3) {
    iletisim_yonlendir('tamam');
}

$ad      = trim((string) ($_POST['ad'] ?? ''));
$telefon = trim((string) ($_POST['telefon'] ?? ''));
$eposta  = trim((string) ($_POST['eposta'] ?? ''));
$mesaj   = trim((string) ($_POST['mesaj'] ?? ''));
$kvkk    = !empty($_POST['kvkk']);

$gecerli = mb_strlen($ad) >= 2 && mb_strlen($ad) <= 100
    && mb_strlen($telefon) >= 7 && mb_strlen($telefon) <= 30
    && preg_match('/^[0-9\s+()\-]+$/', $telefon) === 1
    && strlen((string) preg_replace('/\D/', '', $telefon)) >= 10 && strlen((string) preg_replace('/\D/', '', $telefon)) <= 13
    && mb_strlen($eposta) <= 150 && filter_var($eposta, FILTER_VALIDATE_EMAIL) !== false
    && mb_strlen($mesaj) >= 5 && mb_strlen($mesaj) <= 3000
    && $kvkk;

if (!$gecerli) {
    iletisim_yonlendir('hata');
}

$mailDurum = bildirim_maili_gonder(
    'Web sitesi iletişim formu — ' . $ad,
    "Ad: {$ad}\nTelefon: {$telefon}\nE-posta: {$eposta}\nTarih: " . date('Y-m-d H:i') . "\n\nMesaj:\n{$mesaj}\n",
    $eposta
);

$kayitId = mesaj_ekle(['tur' => 'iletisim', 'ad' => $ad, 'telefon' => $telefon, 'eposta' => $eposta, 'mesaj' => $mesaj, 'mail' => $mailDurum]);
mail_log_yaz('iletisim', $mailDurum, (string) $kayitId);

iletisim_yonlendir($kayitId !== null || $mailDurum === 'gonderildi' ? 'tamam' : 'hata');
