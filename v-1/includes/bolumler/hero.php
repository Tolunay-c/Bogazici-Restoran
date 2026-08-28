<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'hero') ?>
  <div class="hero__gorsel">
    <?= gorsel($b['gorsel'] ?? '', '100vw', [
        'alt' => $b['gorsel_alt'] ?? '',
        'odak' => $b['gorsel_odak'] ?? 'merkez',
        'mobil' => $b['gorsel_mobil'] ?? '',
        'oncelik' => true,
    ]) ?>
  </div>

  <div class="konteyner hero__ic">
    <?php if (!empty($b['ustluk'])): ?><p class="ustluk"><?= e($b['ustluk']) ?></p><?php endif; ?>
    <h1 class="hero__baslik"><?= e($b['baslik'] ?? '') ?></h1>
    <?php if (!empty($b['alt_baslik'])): ?><p class="hero__alt"><?= e($b['alt_baslik']) ?></p><?php endif; ?>
    <div class="btn-grup">
      <?= buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'birincil', 'btn--lg') ?>
      <?= buton($b['buton2_yazi'] ?? '', $b['buton2_link'] ?? '', 'ikincil', 'btn--lg') ?>
    </div>
  </div>
</section>
