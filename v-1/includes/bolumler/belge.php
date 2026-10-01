<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'doc') ?>
  <div class="container container--narrow">
    <?php if (!empty($b['guncelleme'])): ?>
      <p class="doc__updated">Son güncelleme: <?= e($b['guncelleme']) ?></p>
    <?php endif; ?>

    <?php foreach (($b['bolumler'] ?? []) as $m): ?>
      <div class="doc__section">
        <?php if (!empty($m['baslik'])): ?>
          <h2 class="doc__title"><?= e($m['baslik']) ?></h2>
        <?php endif; ?>
        <?php if (!empty($m['metin'])): ?>
          <div class="prose"><p><?= nl2br(e($m['metin'])) ?></p></div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
