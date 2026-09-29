<?php
require_once __DIR__ . '/config.php';
$aktif = 'cerez';
$sayfa_basligi  = 'Çerez Aydınlatma Metni — ' . SITE_ADI;
$sayfa_aciklama = 'Web sitesinde kullanılan çerezlere ilişkin aydınlatma metni.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['cerez']);
require __DIR__ . '/includes/footer.php';
