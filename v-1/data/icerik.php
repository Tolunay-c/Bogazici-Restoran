<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   İÇERİK KATMANI
   - Varsayılan içerik: data/varsayilan.php (fabrika ayarları)
   - Admin panel değişiklikleri: data/veri.json (varsa üzerine biner)
   -------------------------------------------------------------- */

$varsayilan = require __DIR__ . '/varsayilan.php';

$veri = $varsayilan;
$veriYolu = __DIR__ . '/veri.json';
$depoVeri = depo_veri_oku();
if ($depoVeri !== null) {
    $veri = $depoVeri;
} elseif (is_file($veriYolu)) {
    $ham = file_get_contents($veriYolu);
    $yuklu = json_decode((string) $ham, true);
    if (is_array($yuklu) && isset($yuklu['subeler'], $yuklu['sayfalar'])) {
        $veri = $yuklu;
    }
}

if (!defined('SUBELER')) {
    define('SUBELER', $veri['subeler']);
}
$sayfalar = $veri['sayfalar'];

/* --------------------------------------------------------------
   Rezervasyon bölge/saat verisi — admin kapsamında değil.
   -------------------------------------------------------------- */
if (!defined('REZERVASYON_BOLGELER')) {
    define('REZERVASYON_BOLGELER', [
        'uckuyular' => [
            ['id' => 'ic-salon',     'ad' => 'İç Salon',     'kapasite' => 40, 'musait' => 12, 'ikon' => 'chair_alt', 'yerlesim' => [40, 40, 380, 520]],
            ['id' => 'deniz-kenari', 'ad' => 'Deniz Kenarı', 'kapasite' => 8,  'musait' => 2,  'ikon' => 'waves',     'yerlesim' => [440, 40, 320, 160]],
            ['id' => 'teras',        'ad' => 'Teras',        'kapasite' => 20, 'musait' => 6,  'ikon' => 'deck',      'yerlesim' => [440, 220, 320, 160]],
            ['id' => 'bahce',        'ad' => 'Bahçe',        'kapasite' => 14, 'musait' => 4,  'ikon' => 'yard',      'yerlesim' => [440, 400, 320, 160]],
        ],
        'narlidere' => [
            ['id' => 'ic-salon',      'ad' => 'İç Salon',      'kapasite' => 30, 'musait' => 15, 'ikon' => 'chair_alt', 'yerlesim' => [40, 40, 380, 520]],
            ['id' => 'sahil-terasi',  'ad' => 'Sahil Terası',  'kapasite' => 24, 'musait' => 8,  'ikon' => 'waves',     'yerlesim' => [440, 40, 320, 240]],
            ['id' => 'loca',          'ad' => 'Loca',          'kapasite' => 6,  'musait' => 2,  'ikon' => 'star',      'yerlesim' => [440, 300, 320, 260]],
        ],
        'bostanli' => [
            ['id' => 'ic-salon',     'ad' => 'İç Salon',     'kapasite' => 50, 'musait' => 20, 'ikon' => 'chair_alt', 'yerlesim' => [40, 40, 380, 520]],
            ['id' => 'deniz-kenari', 'ad' => 'Deniz Kenarı', 'kapasite' => 6,  'musait' => 0,  'ikon' => 'waves',     'yerlesim' => [440, 40, 320, 160]],
            ['id' => 'teras',        'ad' => 'Teras',        'kapasite' => 22, 'musait' => 7,  'ikon' => 'deck',      'yerlesim' => [440, 220, 320, 160]],
            ['id' => 'bahce',        'ad' => 'Bahçe',        'kapasite' => 18, 'musait' => 9,  'ikon' => 'yard',      'yerlesim' => [440, 400, 320, 160]],
        ],
    ]);
}

if (!defined('REZERVASYON_SAATLERI')) {
    define('REZERVASYON_SAATLERI', [
        'Öğle servisi' => ['12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00'],
        'Akşam servisi' => ['18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'],
    ]);
}
