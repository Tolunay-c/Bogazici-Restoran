<?php
/** @var array $b */
$ogeler = $b['ogeler'] ?? [];
?>
<?= bolum_ac($b, 'card-grid') ?>
  <div class="container">
    <?= bolum_basligi($b, 'orta') ?>
    <ul class="card-grid__list" data-adet="<?= count($ogeler) ?>">
      <?php foreach ($ogeler as $o): ?>
        <li class="card <?= !empty($o['link']) ? 'card--link' : '' ?>" data-goster>
          <?php if (!empty($o['gorsel'])): ?>
            <div class="card__image" style="--oran:3/2">
              <?= gorsel($o['gorsel'], '(min-width:900px) 520px, (min-width:640px) 75vw, 150vw', [
                  'alt' => $o['gorsel_alt'] ?? '',
                  'odak' => $o['gorsel_odak'] ?? 'merkez',
              ]) ?>
            </div>
          <?php endif; ?>
          <div class="card__body">
            <h3 class="card__title">
              <?php if (!empty($o['link'])): ?>
                <a class="card__link" href="<?= e($o['link']) ?>"><?= e($o['baslik'] ?? '') ?></a>
              <?php else: ?>
                <?= e($o['baslik'] ?? '') ?>
              <?php endif; ?>
            </h3>
            <?php if (!empty($o['metin'])): ?><p class="card__text"><?= e($o['metin']) ?></p><?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
