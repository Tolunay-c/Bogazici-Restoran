<?php



/** @var string $sayfa_basligi */
/** @var string $sayfa_aciklama */
/** @var string $aktif  index|kurumsal|subeler|hizmetler|menu|rezervasyon|galeri|iletisim */

$aktif           = $aktif           ?? '';
$sayfa_basligi   = $sayfa_basligi   ?? SITE_ADI;
$sayfa_aciklama  = $sayfa_aciklama  ?? '';

$menu = [
    'index'       => ['Ana Sayfa',  '/'],
    'kurumsal'    => ['Kurumsal',   '/kurumsal.php'],
    'subeler'     => ['Şubeler',    '/subeler.php'],
    'menu'        => ['Menü',       '/menu.php'],
    'hizmetler'   => ['Hizmetler',  '/hizmetler.php'],
    'iletisim'    => ['İletişim',   '/iletisim.php'],
];
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($sayfa_basligi) ?></title>
<meta name="description" content="<?= e($sayfa_aciklama) ?>">
<link rel="canonical" href="<?= e(SITE_URL . $_SERVER['REQUEST_URI']) ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@500;600&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0&display=block">

<link rel="stylesheet" href="<?= VARLIK ?>/css/tokens.css?v=<?= SURUM ?>">
<link rel="stylesheet" href="<?= VARLIK ?>/css/base.css?v=<?= SURUM ?>">
<link rel="stylesheet" href="<?= VARLIK ?>/css/bilesenler.css?v=<?= SURUM ?>">
<link rel="stylesheet" href="<?= VARLIK ?>/css/bolumler.css?v=<?= SURUM ?>">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" defer></script>

<meta name="theme-color" content="#0E1F26">
<link rel="icon" href="<?= VARLIK ?>/img/favicon.svg" type="image/svg+xml">
</head>
<body>

<a class="skip-link" href="#icerik">İçeriğe geç</a>

<header class="site-header">
  <div class="container site-header__inner">
    <a class="site-header__logo" href="/"><?= e(SITE_ADI) ?></a>

    <nav class="site-header__menu" aria-label="Ana menü">
      <?php foreach ($menu as $anahtar => [$ad, $link]): ?>
        <a href="<?= e($link) ?>"<?= $aktif === $anahtar ? ' aria-current="page"' : '' ?>><?= e($ad) ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="site-header__actions">
      <?php if (REZERVASYON_AKTIF): ?><a class="btn btn--primary btn--sm" href="/rezervasyon.php">Rezervasyon</a><?php endif; ?>
      <button class="menu-toggle" type="button" data-cekmece-ac aria-label="Menüyü aç" aria-expanded="false" aria-controls="cekmece">
        <span class="icon" aria-hidden="true">menu</span>
      </button>
    </div>
  </div>
</header>

<dialog class="drawer" id="cekmece" aria-label="Site menüsü">
  <div class="drawer__inner">
    <div class="drawer__top">
      <span class="site-header__logo"><?= e(SITE_ADI) ?></span>
      <button class="menu-toggle" type="button" data-cekmece-kapat aria-label="Menüyü kapat">
        <span class="icon" aria-hidden="true">close</span>
      </button>
    </div>

    <nav class="drawer__menu" aria-label="Mobil menü">
      <?php foreach ($menu as $anahtar => [$ad, $link]): ?>
        <a href="<?= e($link) ?>"<?= $aktif === $anahtar ? ' aria-current="page"' : '' ?>><?= e($ad) ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="drawer__sub">
      <?php if (REZERVASYON_AKTIF): ?><a class="btn btn--primary btn--full" href="/rezervasyon.php">Rezervasyon yap</a><?php endif; ?>
      <a class="btn btn--secondary btn--full" href="tel:+908508500850">0850 850 0850</a>
    </div>
  </div>
</dialog>

<main id="icerik">
