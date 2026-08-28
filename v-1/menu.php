<?php
require_once __DIR__ . '/config.php';
$aktif = 'menu';
$sayfa_basligi  = 'Menü — ' . SITE_ADI;
$sayfa_aciklama = 'Mezeler, ara sıcaklar, ızgara balık ve tatlılar. Paket servise uygun ürünler işaretlidir.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['menu']);
require __DIR__ . '/includes/footer.php';
