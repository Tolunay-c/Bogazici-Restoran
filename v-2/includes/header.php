<?php
/** @var string $sayfa_basligi */
/** @var string $sayfa_aciklama */
/** @var string $aktif  index|kurumsal|subeler|hizmetler|menu|rezervasyon|galeri|iletisim */

$aktif           = $aktif           ?? '';
$sayfa_basligi   = $sayfa_basligi   ?? SITE_ADI;
$sayfa_aciklama  = $sayfa_aciklama  ?? '';
$sayfa_js        = $sayfa_js        ?? null;   // sayfaya özel ek js dosyası
$sayfa_leaflet   = $sayfa_leaflet   ?? false;  // haritalı sayfa (subeler)

$menu = [
    'kurumsal'    => ['Kurumsal',   '/kurumsal.php'],
    'subeler'     => ['Şubeler',    '/subeler.php'],
    'menu'        => ['Menü',       '/menu.php'],
    'hizmetler'   => ['Hizmetler',  '/hizmetler.php'],
    'galeri'      => ['Galeri',     '/galeri.php'],
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&display=swap">

<link rel="stylesheet" href="<?= VARLIK ?>/css/tokens.css?v=<?= SURUM ?>">
<link rel="stylesheet" href="<?= VARLIK ?>/css/base.css?v=<?= SURUM ?>">
<link rel="stylesheet" href="<?= VARLIK ?>/css/bilesenler.css?v=<?= SURUM ?>">
<link rel="stylesheet" href="<?= VARLIK ?>/css/bolumler.css?v=<?= SURUM ?>">

<?php if ($sayfa_leaflet): ?>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
          integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" defer></script>
<?php endif; ?>

<meta name="theme-color" content="#0E1B2C">
<link rel="icon" href="<?= VARLIK ?>/img/favicon.svg" type="image/svg+xml">
</head>
<body>

<a class="atla-baglantisi" href="#icerik">İçeriğe geç</a>

<header class="ust">
  <div class="ust__utility">
    <div class="konteyner">
      <span><a href="tel:+902321234567" class="baglanti-vurgu">0232 123 45 67</a></span>
      <span>Alsancak · Çeşme · Karşıyaka</span>
    </div>
  </div>

  <div class="konteyner ust__ic">
    <a class="ust__logo" href="/">Boğaziçi</a>

    <nav class="ust__menu" aria-label="Ana menü">
      <?php foreach ($menu as $anahtar => [$ad, $link]): ?>
        <a href="<?= e($link) ?>"<?= $aktif === $anahtar ? ' aria-current="page"' : '' ?>><?= e($ad) ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="ust__aksiyon">
      <a class="btn btn--birincil btn--sm" href="/rezervasyon.php">Rezervasyon</a>
      <button class="menu-btn" type="button" data-cekmece-ac aria-label="Menüyü aç" aria-expanded="false" aria-controls="cekmece">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <path d="M3 6h18M3 12h18M3 18h18" stroke-linecap="round"/>
        </svg>
      </button>
    </div>
  </div>
</header>

<dialog class="cekmece" id="cekmece" aria-label="Site menüsü">
  <div class="cekmece__ic">
    <div class="cekmece__ust">
      <span class="ust__logo">Boğaziçi</span>
      <button class="menu-btn" type="button" data-cekmece-kapat aria-label="Menüyü kapat">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <path d="M6 6l12 12M18 6l-12 12" stroke-linecap="round"/>
        </svg>
      </button>
    </div>

    <nav class="cekmece__menu" aria-label="Mobil menü">
      <?php foreach ($menu as $anahtar => [$ad, $link]): ?>
        <a href="<?= e($link) ?>"<?= $aktif === $anahtar ? ' aria-current="page"' : '' ?>><?= e($ad) ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="cekmece__alt">
      <a class="btn btn--birincil btn--tam" href="/rezervasyon.php">Rezervasyon yap</a>
      <a class="btn btn--ikincil btn--tam" href="tel:+902321234567">0232 123 45 67</a>
    </div>
  </div>
</dialog>

<main id="icerik">
