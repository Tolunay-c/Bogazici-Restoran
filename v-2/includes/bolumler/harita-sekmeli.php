<?php /** @var array $b */ ?>
<section class="harita-sekmeli" id="harita">
  <div class="konteyner">

    <header class="bolum-basligi bolum-basligi--merkez" data-reveal>
      <?php if (!empty($b['ustluk'])): ?>
        <p class="ustluk"><?= e($b['ustluk']) ?></p>
      <?php endif; ?>
      <h2 class="bolum-basligi__baslik"><?= e($b['baslik']) ?></h2>
      <?php if (!empty($b['alt_baslik'])): ?>
        <p class="bolum-basligi__alt"><?= e($b['alt_baslik']) ?></p>
      <?php endif; ?>
    </header>

    <div class="harita-sekmeli__ic" data-reveal>
      <div class="harita-sekmeli__sekmeler" role="tablist" aria-label="Şubeler">
        <?php foreach (SUBELER as $i => $s): ?>
          <button type="button"
                  class="harita-sekmeli__sekme"
                  role="tab"
                  data-harita-hedef="<?= e($s['slug']) ?>"
                  aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                  tabindex="<?= $i === 0 ? '0' : '-1' ?>">
            <?= e(mb_strtoupper($s['ad'], 'UTF-8')) ?>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="harita-sekmeli__cerceve">
        <div class="harita-sekmeli__harita"
             data-harita-cok
             data-harita-etiket="Şube"
             data-harita-baslangic-lat="<?= e((string)SUBELER[0]['enlem']) ?>"
             data-harita-baslangic-lng="<?= e((string)SUBELER[0]['boylam']) ?>"
             role="region"
             aria-label="Şube haritası"></div>

        <div class="harita-sekmeli__alt">
          <?php foreach (SUBELER as $i => $s): ?>
            <a class="harita-sekmeli__panel<?= $i === 0 ? ' aktif' : '' ?>"
               data-harita-panel="<?= e($s['slug']) ?>"
               data-lat="<?= e((string)$s['enlem']) ?>"
               data-lng="<?= e((string)$s['boylam']) ?>"
               data-ad="<?= e($s['ad']) ?>"
               href="<?= e($s['yol_tarifi']) ?>"
               target="_blank" rel="noopener">
              <span><?= e($s['ad']) ?> — <?= e($s['adres']) ?></span>
              <span class="harita-sekmeli__ok" aria-hidden="true">Google Maps’te Aç →</span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</section>
