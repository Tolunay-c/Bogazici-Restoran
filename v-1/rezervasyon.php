<?php
require_once __DIR__ . '/config.php';
if (!REZERVASYON_AKTIF) {
    header('Location: /subeler.php', true, 302); // geçici kapalı
    exit;
}
$aktif = 'rezervasyon';
$sayfa_basligi  = 'Rezervasyon — ' . SITE_ADI;
$sayfa_aciklama = 'Şube ve bölgeyi seçin, tarih ve saatinizi belirleyin. Rezervasyonunuz mesai saatinde onaylanır.';
require __DIR__ . '/includes/header.php';
bolumleri_yaz($sayfalar['rezervasyon']);
require __DIR__ . '/includes/footer.php';
