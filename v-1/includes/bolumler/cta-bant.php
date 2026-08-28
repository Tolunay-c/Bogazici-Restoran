<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'cta-bant') ?>
  <div class="konteyner">
    <div class="cta-bant__ic">
      <div>
        <?php if (!empty($b['ustluk'])): ?><p class="ustluk"><?= e($b['ustluk']) ?></p><?php endif; ?>
        <h2><?= e($b['baslik'] ?? '') ?></h2>
        <?php if (!empty($b['metin'])): ?><p class="cta-bant__metin"><?= e($b['metin']) ?></p><?php endif; ?>
      </div>
      <div class="btn-grup">
        <?= buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'birincil', 'btn--lg') ?>
      </div>
    </div>
  </div>
</section>
