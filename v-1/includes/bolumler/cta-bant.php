<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'cta-band') ?>
  <div class="container">
    <div class="cta-band__inner">
      <div>
        <?php if (!empty($b['ustluk'])): ?><p class="eyebrow"><?= e($b['ustluk']) ?></p><?php endif; ?>
        <h2><?= e($b['baslik'] ?? '') ?></h2>
        <?php if (!empty($b['metin'])): ?><p class="cta-band__text"><?= e($b['metin']) ?></p><?php endif; ?>
      </div>
      <div class="btn-group">
        <?= buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'birincil', 'btn--lg') ?>
        <?php if (!empty($b['buton2_yazi'])): ?>
          <?= buton($b['buton2_yazi'], $b['buton2_link'] ?? '', 'ikincil', 'btn--lg') ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
