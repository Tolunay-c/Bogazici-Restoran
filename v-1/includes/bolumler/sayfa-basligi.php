<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'page-header') ?>
  <div class="hero__image">
    <?= gorsel($b['gorsel'] ?? '', '100vw', [
        'alt' => $b['gorsel_alt'] ?? '',
        'odak' => $b['gorsel_odak'] ?? 'merkez',
        'oncelik' => true,
    ]) ?>
  </div>
  <div class="container">
    <?= bolum_basligi($b, 'sol', 'h1') ?>
  </div>
</section>
