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
     'gorsel' => $sube['banner'] ?? '', 'gorsel_alt' => ''],

    ['tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
     'ustluk' => 'Mekân', 'baslik' => $sube['ad'] . '’ta bizi bulun',
     'metin' => $sube['adres'] . "\n" . $sube['saat'] . (!empty($sube['not']) ? "\n" . $sube['not'] : '') . "\nBölgeler: " . implode(', ', $sube['bolgeler']),
     'gorsel' => $sube['gorsel'], 'gorsel_alt' => $sube['ad'] . ' şubesi',
     'buton_yazi' => 'Yol tarifi al', 'buton_link' => $sube['yol_tarifi']],

    ['tip' => 'harita', 'zemin' => 'kum', 'baslik' => 'Konum', 'sube' => $sube],

    ['tip' => 'rezervasyon-blok', 'zemin' => 'koyu',
     'ustluk' => 'Rezervasyon', 'baslik' => $sube['ad'] . ' için yer ayırın',
     'metin' => 'Tarih ve saati seçin, rezervasyon talebinizi iletin; ekibimiz sizinle iletişime geçerek teyit etsin.',
     'buton_yazi' => 'Rezervasyona başla',
     'buton_link' => '/rezervasyon.php?sube=' . $sube['slug']],
];

require __DIR__ . '/includes/header.php';
bolumleri_yaz($bolumler);
require __DIR__ . '/includes/footer.php';
