<?php
require_once __DIR__ . '/config.php';

/* Üç şube de BU tek şablondan üretiliyor. İçerik farkı yalnızca
   veriden geliyor; sayfa yapısı tek yerde tanımlı. */
$slug = $_GET['s'] ?? '';
$sube = null;
foreach (SUBELER as $s) {
    if ($s['slug'] === $slug) { $sube = $s; break; }
}
if ($sube === null) {
    header('Location: /subeler.php', true, 302);
    exit;
}

$aktif = 'subeler';
$sayfa_basligi  = $sube['ad'] . ' Şubesi — ' . SITE_ADI;
$sayfa_aciklama = $sube['ad'] . ' şubemiz: ' . $sube['adres'] . '. ' . $sube['saat'];

$bolumler = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu',
     'ustluk' => 'Şube', 'baslik' => $sube['ad'],
     'gorsel' => $sube['gorsel'], 'gorsel_odak' => 'merkez', 'gorsel_alt' => $sube['ad'] . ' şubesi'],

    ['tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
     'ustluk' => 'Mekân', 'baslik' => $sube['ad'] . '’ta bizi bulun',
     'metin' => $sube['adres'] . "\n" . $sube['saat'] . "\nBölgeler: " . implode(', ', $sube['bolgeler']),
     'gorsel' => 'sube-' . $sube['slug'] . '-ic.webp', 'gorsel_alt' => $sube['ad'] . ' iç mekân',
     'buton_yazi' => 'Yol tarifi al', 'buton_link' => $sube['yol_tarifi']],

    ['tip' => 'harita', 'zemin' => 'kum', 'baslik' => 'Konum', 'sube' => $sube],

    ['tip' => 'rezervasyon-blok', 'zemin' => 'koyu',
     'ustluk' => 'Rezervasyon', 'baslik' => $sube['ad'] . ' için yer ayırın',
     'metin' => 'Bölgeyi ve saati seçin, rezervasyonunuz anında onaylansın.',
     'buton_yazi' => 'Rezervasyona başla',
     'buton_link' => '/rezervasyon.php?sube=' . $sube['slug']],
];

require __DIR__ . '/includes/header.php';
bolumleri_yaz($bolumler);
require __DIR__ . '/includes/footer.php';
