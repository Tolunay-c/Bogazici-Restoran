<?php
require_once __DIR__ . '/config.php';

$aktif          = 'subeler';
$sayfa_basligi  = 'Şubeler — ' . SITE_ADI;
$sayfa_aciklama = 'İzmir’de üç şube: Üçkuyular, Narlıdere, Bostanlı. Adres, saat, telefon ve yol tarifi.';
$sayfa_leaflet  = true;
$sayfa_js       = 'harita.js';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['subeler']);

require __DIR__ . '/includes/footer.php';
