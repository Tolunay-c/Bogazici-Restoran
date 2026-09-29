<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'belge') ?>
  <div class="konteyner konteyner--dar">
    <?php if (!empty($b['guncelleme'])): ?>
      <p class="belge__guncelleme">Son güncelleme: <?= e($b['guncelleme']) ?></p>
    <?php endif; ?>

    <?php foreach (($b['bolumler'] ?? []) as $m): ?>
      <div class="belge__bolum">
        <?php if (!empty($m['baslik'])): ?>
          <h2 class="belge__baslik"><?= e($m['baslik']) ?></h2>
        <?php endif; ?>
        <?php if (!empty($m['metin'])): ?>
          <div class="metin-akis"><p><?= nl2br(e($m['metin'])) ?></p></div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
