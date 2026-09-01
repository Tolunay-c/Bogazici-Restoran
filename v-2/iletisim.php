<?php
require_once __DIR__ . '/config.php';

$aktif          = 'iletisim';
$sayfa_basligi  = 'İletişim — ' . SITE_ADI;
$sayfa_aciklama = 'Yazın, arayın ya da şubelerimize uğrayın. Mesajlar mesai saatinde yanıtlanır.';

/* --------------------------------------------------------------
   POST işleme
   -------------------------------------------------------------- */
$formHatalar = [];
$formBasari  = null;
$formDeger   = [
    'ad'     => '',
    'eposta' => '',
    'tel'    => '',
    'konu'   => 'genel',
    'mesaj'  => '',
    'kvkk'   => false,
];

$gecerliKonular = ['genel', 'rezervasyon', 'etkinlik', 'basin', 'geribildirim'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formDeger = [
        'ad'     => trim((string)($_POST['ad']     ?? '')),
        'eposta' => trim((string)($_POST['eposta'] ?? '')),
        'tel'    => trim((string)($_POST['tel']    ?? '')),
        'konu'   => (string)($_POST['konu']        ?? 'genel'),
        'mesaj'  => trim((string)($_POST['mesaj']  ?? '')),
        'kvkk'   => !empty($_POST['kvkk']),
    ];

    if (!csrf_dogrula($_POST['csrf'] ?? null)) {
        $formHatalar['form'] = 'Oturum süresi doldu, lütfen sayfayı yenileyin.';
    }

    if ($formDeger['ad'] === '' || mb_strlen($formDeger['ad']) < 3) {
        $formHatalar['ad'] = 'Ad soyad zorunlu.';
    }
    if (!filter_var($formDeger['eposta'], FILTER_VALIDATE_EMAIL)) {
        $formHatalar['eposta'] = 'Geçerli bir e-posta girin.';
    }
    if ($formDeger['tel'] !== '' && !preg_match('/^[0-9+()\s\-]{10,20}$/', $formDeger['tel'])) {
        $formHatalar['tel'] = 'Telefon formatı geçersiz.';
    }
    if (!in_array($formDeger['konu'], $gecerliKonular, true)) {
        $formHatalar['konu'] = 'Konu seçin.';
    }
    if ($formDeger['mesaj'] === '' || mb_strlen($formDeger['mesaj']) < 10) {
        $formHatalar['mesaj'] = 'Mesaj en az 10 karakter olmalı.';
    } elseif (mb_strlen($formDeger['mesaj']) > 2000) {
        $formHatalar['mesaj'] = 'Mesaj en fazla 2000 karakter.';
    }
    if (!$formDeger['kvkk']) {
        $formHatalar['kvkk'] = 'Devam etmek için KVKK onayı gerekli.';
    }

    if (!$formHatalar) {
        // Gerçek entegrasyon (e-posta / DB / helpdesk) burada olacak.
        $formBasari = 'Mesajınız alındı. Mesai saatinde size döneceğiz.';
        $formDeger  = [
            'ad'=>'','eposta'=>'','tel'=>'','konu'=>'genel','mesaj'=>'','kvkk'=>false,
        ];
    }
}

/* Form state'ini ilgili bölüme enjekte et. */
foreach ($sayfalar['iletisim'] as &$blok) {
    if (($blok['tip'] ?? '') === 'iletisim-form') {
        $blok['deger']   = $formDeger;
        $blok['hatalar'] = $formHatalar;
        $blok['basari']  = $formBasari;
        $blok['csrf']    = csrf_token();
    }
}
unset($blok);

require __DIR__ . '/includes/header.php';

bolumleri_yaz($sayfalar['iletisim']);

require __DIR__ . '/includes/footer.php';
