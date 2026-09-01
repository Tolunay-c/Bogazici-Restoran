<?php
require_once __DIR__ . '/config.php';

$aktif          = 'menu';
$sayfa_basligi  = 'Menü — ' . SITE_ADI;
$sayfa_aciklama = 'Meze, deniz ürünleri, ızgara, tatlı ve içecekler. Mevsime göre yenilenir; fiyatlar KDV dâhil.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['menu']);

require __DIR__ . '/includes/footer.php';
