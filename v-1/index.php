<?php
require_once __DIR__ . '/config.php';

$aktif          = 'index';
$sayfa_basligi  = SITE_ADI . ' — İzmir’de üç şubede deniz ürünleri ve Türk mutfağı';
$sayfa_aciklama = 'Üçkuyular, Narlıdere ve Bostanlı şubelerimizde özenli mutfak, kaliteli hizmet ve keyifli atmosfer. Rezervasyon mesai saatinde onaylanır.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['anasayfa']);

require __DIR__ . '/includes/footer.php';
