<?php
require_once __DIR__ . '/config.php';

$aktif          = 'subeler';
$sayfa_basligi  = 'Şubeler — ' . SITE_ADI;
$sayfa_aciklama = 'İzmir’de üç şube: Alsancak, Çeşme, Karşıyaka. Adres, saat, telefon ve yol tarifi.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['subeler']);

require __DIR__ . '/includes/footer.php';
