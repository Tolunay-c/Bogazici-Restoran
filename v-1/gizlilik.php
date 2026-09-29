<?php
require_once __DIR__ . '/config.php';
$aktif = 'gizlilik';
$sayfa_basligi  = 'Gizlilik Politikası — ' . SITE_ADI;
$sayfa_aciklama = 'Web sitesi kullanımına ilişkin gizlilik politikası.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['gizlilik']);
require __DIR__ . '/includes/footer.php';
