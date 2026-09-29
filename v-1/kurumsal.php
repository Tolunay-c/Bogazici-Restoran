<?php
require_once __DIR__ . '/config.php';

$aktif          = 'kurumsal';
$sayfa_basligi  = 'Kurumsal — ' . SITE_ADI;
$sayfa_aciklama = '1993’ten bu yana İzmir’de. Bostanlı, Üçkuyular ve Narlıdere şubelerimizle Boğaziçi Restaurant’ın hikâyesi.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['kurumsal']);

require __DIR__ . '/includes/footer.php';
