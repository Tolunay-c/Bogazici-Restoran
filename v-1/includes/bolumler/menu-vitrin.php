<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'menu-showcase') ?>
  <div class="container">
    <?= bolum_basligi($b) ?>
    <ul class="menu-showcase__list">
      <?php foreach (($b['ogeler'] ?? []) as $o): ?>
        <li class="card" data-goster>
          <?php if (!empty($o['gorsel'])): ?>
            <div class="card__image" style="--oran:1/1">
              <?= gorsel($o['gorsel'], '(min-width:900px) 260px, (min-width:640px) 45vw, 78vw', [
                  'alt' => $o['baslik'] ?? '',
              ]) ?>
            </div>
          <?php endif; ?>
          <div class="card__body">
            <div class="menu-item__top">
              <h3 class="card__title"><?= e($o['baslik'] ?? '') ?></h3>
            </div>
            <?php if (!empty($o['metin'])): ?><p class="card__text"><?= e($o['metin']) ?></p><?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if ($btn = buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'ikincil')): ?>
      <div class="gallery-preview__sub"><?= $btn ?></div>
    <?php endif; ?>
  </div>
</section>
