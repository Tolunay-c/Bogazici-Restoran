<?php
require_once __DIR__ . '/config.php';
$aktif = 'galeri';
$sayfa_basligi  = 'Galeri — ' . SITE_ADI;
$sayfa_aciklama = 'Mekân, mutfak ve tabaklardan kareler.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['galeri']);
require __DIR__ . '/includes/footer.php';
