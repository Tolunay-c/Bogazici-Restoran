<?php
require_once __DIR__ . '/config.php';
$aktif = 'kvkk';
$sayfa_basligi  = 'KVKK Aydınlatma Metni — ' . SITE_ADI;
$sayfa_aciklama = 'Kişisel verilerin korunmasına ilişkin aydınlatma metni.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['kvkk']);
require __DIR__ . '/includes/footer.php';
