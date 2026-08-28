<?php
require_once __DIR__ . '/config.php';

$aktif          = 'index';
$sayfa_basligi  = SITE_ADI . ' — İzmir’de üç şubede deniz ürünleri ve Türk mutfağı';
$sayfa_aciklama = 'Alsancak, Çeşme ve Karşıyaka şubelerimizde günlük tezgâh, meze ve ızgara. Online rezervasyon anında onaylanır.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['anasayfa']);

require __DIR__ . '/includes/footer.php';
