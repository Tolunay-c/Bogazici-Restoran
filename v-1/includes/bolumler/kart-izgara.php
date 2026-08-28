<?php
/** @var array $b */
$ogeler = $b['ogeler'] ?? [];
?>
<?= bolum_ac($b, 'kart-izgara') ?>
  <div class="konteyner">
    <?= bolum_basligi($b, 'orta') ?>
    <ul class="kart-izgara__liste" data-adet="<?= count($ogeler) ?>">
      <?php foreach ($ogeler as $o): ?>
        <li class="kart <?= !empty($o['link']) ? 'kart--link' : '' ?>" data-goster>
          <?php if (!empty($o['gorsel'])): ?>
            <div class="kart__gorsel" style="--oran:3/2">
              <?= gorsel($o['gorsel'], '(min-width:900px) 360px, (min-width:640px) 50vw, 100vw', [
                  'alt' => $o['gorsel_alt'] ?? '',
                  'odak' => $o['gorsel_odak'] ?? 'merkez',
              ]) ?>
            </div>
          <?php endif; ?>
          <div class="kart__govde">
            <h3 class="kart__baslik">
              <?php if (!empty($o['link'])): ?>
                <a class="kart__baglanti" href="<?= e($o['link']) ?>"><?= e($o['baslik'] ?? '') ?></a>
              <?php else: ?>
                <?= e($o['baslik'] ?? '') ?>
              <?php endif; ?>
            </h3>
            <?php if (!empty($o['metin'])): ?><p class="kart__metin"><?= e($o['metin']) ?></p><?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
