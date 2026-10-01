<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'faq') ?>
  <div class="container">
    <div class="faq__inner">
      <div class="faq__title">
        <?= bolum_basligi($b) ?>
      </div>
      <div class="faq__list">
        <?php foreach (($b['ogeler'] ?? []) as $i => $o): ?>
          <details class="faq__item"<?= $i === 0 ? ' open data-mobilde-kapali' : '' ?>>
            <summary class="faq__question"><?= e($o['baslik'] ?? '') ?></summary>
            <div class="faq__answer"><?= nl2br(e($o['metin'] ?? '')) ?></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
