<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'galeri-onizleme') ?>
  <div class="konteyner">
    <?= bolum_basligi($b) ?>
    <div class="galeri" data-masonry<?= !empty($b['kirp']) ? ' data-kirp' : '' ?>>
      <?php foreach (($b['ogeler'] ?? []) as $i => $o): ?>
        <div class="galeri__oge">
          <button class="galeri__tetik" type="button"
                  data-lightbox="<?= e(gorsel_url($o['gorsel'], 1440)) ?>"
                  aria-label="<?= e($o['gorsel_alt'] ?? 'Görseli büyüt') ?>">
            <?= gorsel($o['gorsel'], '(min-width:900px) 50vw, 100vw', [
                'alt'     => $o['gorsel_alt'] ?? '',
                'en'      => $o['en']  ?? 1600,
                'boy'     => $o['boy'] ?? 1067,
                'oncelik' => $i < 4,
            ]) ?>
          </button>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($btn = buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'ikincil')): ?>
      <div class="galeri-onizleme__alt"><?= $btn ?></div>
    <?php endif; ?>
  </div>
</section>
