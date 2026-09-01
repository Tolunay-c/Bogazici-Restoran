<?php
require_once __DIR__ . '/config.php';

$aktif          = 'kurumsal';
$sayfa_basligi  = 'Kurumsal — ' . SITE_ADI;
$sayfa_aciklama = '1998’den bu yana İzmir’de üç şubede tek mutfak. Hikâyemiz, ilkelerimiz ve zaman çizelgesi.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['kurumsal']);

require __DIR__ . '/includes/footer.php';
