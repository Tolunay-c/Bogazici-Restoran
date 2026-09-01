<?php /** @var array $b */ ?>
<section class="menu-bolum" id="menu-<?= e($b['numara'] ?? '') ?>">
  <div class="konteyner">

    <header class="menu-bolum__basluk" data-reveal>
      <?php if (!empty($b['numara'])): ?>
        <p class="hikaye__numara" aria-hidden="true"><?= e($b['numara']) ?></p>
      <?php endif; ?>
      <h2 class="menu-bolum__ad"><?= e($b['ad']) ?></h2>
      <?php if (!empty($b['aciklama'])): ?>
        <p class="menu-bolum__aciklama"><?= e($b['aciklama']) ?></p>
      <?php endif; ?>
    </header>

    <div class="menu-bolum__izgara" data-reveal>
      <?php foreach ($b['ogeler'] as $oge): ?>
        <article class="menu-oge">
          <div class="menu-oge__sol">
            <h3 class="menu-oge__ad">
              <?= e($oge['ad']) ?>
              <?php if (!empty($oge['etiket'])): ?>
                <span class="menu-oge__etiket"><?= e($oge['etiket']) ?></span>
              <?php endif; ?>
            </h3>
            <?php if (!empty($oge['aciklama'])): ?>
              <p class="menu-oge__aciklama"><?= e($oge['aciklama']) ?></p>
            <?php endif; ?>
          </div>
          <p class="menu-oge__fiyat" aria-label="Fiyat">
            <?= e($oge['fiyat']) ?> <span aria-hidden="true">₺</span>
          </p>
        </article>
      <?php endforeach; ?>
    </div>

  </div>
</section>
