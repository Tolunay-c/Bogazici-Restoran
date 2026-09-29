<?php
require_once __DIR__ . '/config.php';
$aktif = 'ik';
$sayfa_basligi  = 'İnsan Kaynakları — ' . SITE_ADI;
$sayfa_aciklama = 'Boğaziçi Restaurant ekibine katılım ve başvuru süreci.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['ik']);
require __DIR__ . '/includes/footer.php';
