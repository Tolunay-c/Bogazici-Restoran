<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'sayfa-basligi') ?>
  <div class="hero__gorsel">
    <?= gorsel($b['gorsel'] ?? '', '100vw', [
        'alt' => $b['gorsel_alt'] ?? '',
        'odak' => $b['gorsel_odak'] ?? 'merkez',
        'oncelik' => true,
    ]) ?>
  </div>
  <div class="konteyner">
    <?= bolum_basligi($b, 'sol', 'h1') ?>
  </div>
</section>
