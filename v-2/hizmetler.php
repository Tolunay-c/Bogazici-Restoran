<?php
require_once __DIR__ . '/config.php';

$aktif          = 'hizmetler';
$sayfa_basligi  = 'Hizmetler — ' . SITE_ADI;
$sayfa_aciklama = 'İş toplantıları, kokteyl & etkinlik, catering ve paket servis. Boğaziçi dokunuşuyla size özel planlama.';

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['hizmetler']);

require __DIR__ . '/includes/footer.php';
