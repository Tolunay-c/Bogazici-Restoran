<?php /** @var array $b */ ?>
<section class="sayfa-baslik">
  <div class="konteyner">
    <?php if (!empty($b['ustluk'])): ?>
      <p class="ustluk" data-reveal><?= e($b['ustluk']) ?></p>
    <?php endif; ?>
    <h1 class="sayfa-baslik__baslik" data-reveal><?= e($b['baslik']) ?></h1>
    <?php if (!empty($b['alt_baslik'])): ?>
      <p class="sayfa-baslik__alt" data-reveal><?= e($b['alt_baslik']) ?></p>
    <?php endif; ?>
  </div>
</section>
