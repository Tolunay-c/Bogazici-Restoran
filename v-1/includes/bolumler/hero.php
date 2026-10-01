<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'hero') ?>
  <div class="hero__image">
    <?= gorsel($b['gorsel'] ?? '', '100vw', [
        'alt' => $b['gorsel_alt'] ?? '',
        'odak' => $b['gorsel_odak'] ?? 'merkez',
        'mobil' => $b['gorsel_mobil'] ?? '',
        'oncelik' => true,
    ]) ?>
  </div>

  <div class="container hero__inner">
    <?php if (!empty($b['ustluk'])): ?><p class="eyebrow"><?= e($b['ustluk']) ?></p><?php endif; ?>
    <h1 class="hero__title"><?= e($b['baslik'] ?? '') ?></h1>
    <?php if (!empty($b['alt_baslik'])): ?><p class="hero__sub"><?= e($b['alt_baslik']) ?></p><?php endif; ?>
    <div class="btn-group">
      <?= buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'birincil', 'btn--lg') ?>
      <?= buton($b['buton2_yazi'] ?? '', $b['buton2_link'] ?? '', 'ikincil', 'btn--lg') ?>
    </div>
    <?php if (!empty($b['alt_not'])): ?><p class="hero__note"><?= e($b['alt_not']) ?></p><?php endif; ?>
  </div>
</section>
