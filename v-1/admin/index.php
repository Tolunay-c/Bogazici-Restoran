<?php
declare(strict_types=1);
require_once __DIR__ . '/ortak.php';
admin_zorunlu();

$veri = veri_oku();
$sayfalar = array_filter(array_keys($veri['sayfalar'] ?? []), static fn (string $s): bool => $s !== '');
$subeler  = $veri['subeler'] ?? [];
$gorseller = gorsel_listesi();

require __DIR__ . '/_ust.php';
?>

<section class="admin-blok">
  <h1 class="admin-baslik">Panel</h1>
  <p class="admin-yardim">Sayfaları düzenle, şube bilgilerini güncelle, görselleri yönet.</p>
</section>

<section class="admin-blok">
  <h2 class="admin-ustluk">Sayfalar</h2>
  <div class="admin-izgara admin-izgara--3">
    <?php foreach ($sayfalar as $slug):
      $adet = count($veri['sayfalar'][$slug]);
    ?>
      <a class="admin-kart" href="/admin/sayfa.php?ad=<?= e($slug) ?>">
        <p class="admin-kart__etiket">Sayfa</p>
        <h3 class="admin-kart__baslik"><?= e(sayfa_etiket($slug)) ?></h3>
        <p class="admin-kart__meta"><?= (int) $adet ?> bölüm · <code>/<?= e($slug === 'anasayfa' ? '' : $slug . '.php') ?></code></p>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="admin-blok">
  <h2 class="admin-ustluk">Şube Kayıtları <small style="font-weight:400;color:var(--a-metin-ikincil);letter-spacing:0;text-transform:none;">(ad, adres, telefon, konum, görsel)</small></h2>
  <div class="admin-izgara admin-izgara--3">
    <?php foreach ($subeler as $s): ?>
      <a class="admin-kart" href="/admin/sube.php?slug=<?= e($s['slug']) ?>">
        <p class="admin-kart__etiket">Şube kaydı</p>
        <h3 class="admin-kart__baslik"><?= e($s['ad']) ?></h3>
        <p class="admin-kart__meta"><?= e($s['telefon_yazi'] ?? '') ?></p>
      </a>
    <?php endforeach; ?>
    <a class="admin-kart admin-kart--ekle" href="/admin/sube.php?yeni=1">
      <p class="admin-kart__etiket">+</p>
      <h3 class="admin-kart__baslik">Yeni şube ekle</h3>
    </a>
  </div>
</section>

<section class="admin-blok">
  <h2 class="admin-ustluk">Görseller</h2>
  <p class="admin-yardim"><?= count($gorseller) ?> görsel · <a href="/admin/gorsel.php">Tümünü yönet →</a></p>
  <?php if ($gorseller): ?>
    <div class="admin-gorsel-onizleme">
      <?php foreach (array_slice($gorseller, 0, 12) as $g): ?>
        <div class="admin-gorsel-onizleme__oge">
          <img src="<?= e(gorsel_url($g)) ?>" alt="<?= e(basename($g)) ?>" loading="lazy">
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/_alt.php'; ?>
