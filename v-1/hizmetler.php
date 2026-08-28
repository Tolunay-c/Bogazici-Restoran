<?php
require_once __DIR__ . '/config.php';
$aktif = 'hizmetler';
$sayfa_basligi  = 'Hizmetler — ' . SITE_ADI;
$sayfa_aciklama = 'Özel gün organizasyonu, kurumsal yemek ve paket servis.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['hizmetler']);
require __DIR__ . '/includes/footer.php';
