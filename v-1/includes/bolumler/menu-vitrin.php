<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'menu-vitrin') ?>
  <div class="konteyner">
    <?= bolum_basligi($b) ?>
    <ul class="menu-vitrin__liste">
      <?php foreach (($b['ogeler'] ?? []) as $o): ?>
        <li class="kart" data-goster>
          <?php if (!empty($o['gorsel'])): ?>
            <div class="kart__gorsel" style="--oran:1/1">
              <?= gorsel($o['gorsel'], '(min-width:900px) 260px, (min-width:640px) 45vw, 78vw', [
                  'alt' => $o['baslik'] ?? '',
              ]) ?>
            </div>
          <?php endif; ?>
          <div class="kart__govde">
            <div class="urun__ust">
              <h3 class="kart__baslik"><?= e($o['baslik'] ?? '') ?></h3>
              <span class="urun__nokta" aria-hidden="true"></span>
              <span class="urun__fiyat"><?= e($o['fiyat'] ?? '') ?></span>
            </div>
            <?php if (!empty($o['metin'])): ?><p class="kart__metin"><?= e($o['metin']) ?></p><?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if ($btn = buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'ikincil')): ?>
      <div class="galeri-onizleme__alt"><?= $btn ?></div>
    <?php endif; ?>
  </div>
</section>
