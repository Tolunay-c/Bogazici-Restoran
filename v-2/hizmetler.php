<?php
require_once __DIR__ . '/config.php';

$aktif          = 'hizmetler';
$sayfa_basligi  = 'Hizmetler — ' . SITE_ADI;
$sayfa_aciklama = 'Kurumsal davet, düğün, catering ve özel menü. Üç şubede aynı mutfak, size özel plan.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['hizmetler']);

require __DIR__ . '/includes/footer.php';
