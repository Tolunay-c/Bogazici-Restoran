<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   Boğaziçi Restaurant — genel yapılandırma
   Veritabanına geçildiğinde SADECE data/icerik.php yerini bir
   sorgu katmanı alacak. Bu dosya aynı kalır.
   -------------------------------------------------------------- */

define('SITE_ADI',   'Boğaziçi Restaurant');
define('SITE_URL',   'https://bogazicirestaurant.com.tr');
define('VARLIK',     '/assets');            // assets kök yolu
define('GORSEL_YOL', '/assets/img');        // yüklenen görsellerin kökü
/* css/js cache-buster.
   Yerelde dosya değişince otomatik değişir, önbellek takılmaz.
   Canlıda sabit sürüm kullanılır (her istekte disk okumasın). */
define('YEREL', in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1', 'bogazici.test'], true));

if (YEREL) {
    $ensonDegisim = 0;
    foreach (glob(__DIR__ . '/assets/{css,js}/*.{css,js}', GLOB_BRACE) ?: [] as $dosya) {
        $ensonDegisim = max($ensonDegisim, (int) filemtime($dosya));
    }
    define('SURUM', (string) $ensonDegisim);
} else {
    define('SURUM', '1.0.1');
}

// Görsel türev genişlikleri — panel yüklemede bunları üretecek
const GORSEL_TUREVLERI = [480, 960, 1440, 2200];

// object-position karşılıkları (panelde `gorsel_odak` alanı)
const ODAK_HARITASI = [
    'merkez' => '50% 50%',
    'ust'    => '50% 20%',
    'alt'    => '50% 80%',
    'sol'    => '20% 50%',
    'sag'    => '80% 50%',
];

date_default_timezone_set('Europe/Istanbul');
mb_internal_encoding('UTF-8');

require_once __DIR__ . '/includes/fonksiyonlar.php';
require_once __DIR__ . '/data/icerik.php';
