<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'sss') ?>
  <div class="konteyner">
    <div class="sss__ic">
      <div class="sss__baslik">
        <?= bolum_basligi($b) ?>
      </div>
      <div class="sss__liste">
        <?php foreach (($b['ogeler'] ?? []) as $i => $o): ?>
          <details class="sss__oge"<?= $i === 0 ? ' open data-mobilde-kapali' : '' ?>>
            <summary class="sss__soru"><?= e($o['baslik'] ?? '') ?></summary>
            <div class="sss__cevap"><?= nl2br(e($o['metin'] ?? '')) ?></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
