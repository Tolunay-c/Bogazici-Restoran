<?php
require_once __DIR__ . '/config.php';
$aktif = 'iletisim';
$sayfa_basligi  = 'İletişim — ' . SITE_ADI;
$sayfa_aciklama = 'Üç şubemizin adres ve telefonları, iletişim formu.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['iletisim']);
require __DIR__ . '/includes/footer.php';
