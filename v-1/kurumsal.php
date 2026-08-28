<?php
require_once __DIR__ . '/config.php';

$aktif          = 'kurumsal';
$sayfa_basligi  = 'Kurumsal — ' . SITE_ADI;
$sayfa_aciklama = '1998’den bu yana İzmir’de. Boğaziçi Restaurant’ın hikâyesi ve çalışma biçimi.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['kurumsal']);

require __DIR__ . '/includes/footer.php';
