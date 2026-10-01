<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'stats') ?>
  <div class="container">
    <div class="stats__inner">
      <?php if (!empty($b['gorsel'])): ?>
        <div class="stats__image image-frame">
          <?= gorsel($b['gorsel'], '(min-width:900px) 46vw, 100vw', [
              'alt'  => $b['gorsel_alt'] ?? '',
              'odak' => $b['gorsel_odak'] ?? 'merkez',
          ]) ?>
        </div>
      <?php endif; ?>

      <div class="stats__text">
        <?= bolum_basligi($b) ?>
        <ul class="stats__list">
          <?php foreach (($b['ogeler'] ?? []) as $o): ?>
            <li class="stats__item" data-goster>
              <span class="stats__number" data-sayac><?= e($o['sayi'] ?? '') ?></span>
              <span class="stats__label"><?= e($o['etiket'] ?? '') ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
