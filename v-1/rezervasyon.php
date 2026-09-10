<?php
require_once __DIR__ . '/config.php';
$aktif = 'rezervasyon';
$sayfa_basligi  = 'Rezervasyon — ' . SITE_ADI;
$sayfa_aciklama = 'Şube ve bölgeyi seçin, tarih ve saatinizi belirleyin. Rezervasyonunuz mesai saatinde onaylanır.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['rezervasyon']);
require __DIR__ . '/includes/footer.php';
