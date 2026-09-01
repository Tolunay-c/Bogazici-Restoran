<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   Boğaziçi Restaurant — v-2 (Editorial Coastal)
   Aynı mimari, farklı görsel dil.
   -------------------------------------------------------------- */

define('SITE_ADI',   'Boğaziçi Restaurant');
define('SITE_URL',   'https://bogazicirestaurant.com.tr');
define('SITE_KOK',   __DIR__);              // v-2 fiziksel kökü
define('VARLIK',     '/assets');
define('GORSEL_YOL', '/assets/img');

define('YEREL', in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1', 'bogazici.test'], true));

if (YEREL) {
    $ensonDegisim = 0;
    foreach (glob(__DIR__ . '/assets/{css,js}/*.{css,js}', GLOB_BRACE) ?: [] as $dosya) {
        $ensonDegisim = max($ensonDegisim, (int) filemtime($dosya));
    }
    define('SURUM', (string) $ensonDegisim);
} else {
    define('SURUM', '2.0.0');
}

const GORSEL_TUREVLERI = [480, 960, 1440, 2200];

const ODAK_HARITASI = [
    'merkez' => '50% 50%',
    'ust'    => '50% 20%',
    'alt'    => '50% 80%',
    'sol'    => '20% 50%',
    'sag'    => '80% 50%',
];

date_default_timezone_set('Europe/Istanbul');
mb_internal_encoding('UTF-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/fonksiyonlar.php';
require_once __DIR__ . '/data/icerik.php';
