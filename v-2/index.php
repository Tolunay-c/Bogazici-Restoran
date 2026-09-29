<?php
require_once __DIR__ . '/config.php';

$aktif          = 'index';
$sayfa_basligi  = SITE_ADI . ' — İzmir’de üç şubede Boğaziçi lezzeti';
$sayfa_aciklama = 'Üçkuyular, Narlıdere ve Bostanlı şubelerimizde özenli mutfak, kaliteli hizmet ve keyifli atmosfer.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['anasayfa']);

require __DIR__ . '/includes/footer.php';
