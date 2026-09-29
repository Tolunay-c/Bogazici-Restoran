<?php
require_once __DIR__ . '/config.php';

$aktif          = 'menu';
$sayfa_basligi  = 'Menü — ' . SITE_ADI;
$sayfa_aciklama = 'Mezelerden balık ve deniz ürünlerine, ızgaradan tatlıya Boğaziçi mutfağı. Menü şubelere ve mevsime göre farklılık gösterebilir.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['menu']);

require __DIR__ . '/includes/footer.php';
