<?php
require_once __DIR__ . '/config.php';
$aktif = 'subeler';
$sayfa_basligi  = 'Şubeler — ' . SITE_ADI;
$sayfa_aciklama = 'Üçkuyular, Narlıdere ve Bostanlı şubelerimiz: adres, çalışma saatleri' . (REZERVASYON_AKTIF ? ' ve rezervasyon' : '') . '.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['subeler']);
require __DIR__ . '/includes/footer.php';
