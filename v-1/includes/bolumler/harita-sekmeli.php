<?php
/** @var array $b */
$ilk = SUBELER[0];
?>
<?= bolum_ac($b, 'map-tabs') ?>
  <div class="container">
    <?= bolum_basligi($b, 'orta') ?>

    <div class="map-tabs__tabs" role="tablist" aria-label="Şube haritası">
      <?php foreach (SUBELER as $i => $s): ?>
        <button type="button"
                class="map-tabs__tab<?= $i === 0 ? ' map-tabs__tab--active' : '' ?>"
                role="tab" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                data-enlem="<?= e((string) $s['enlem']) ?>"
                data-boylam="<?= e((string) $s['boylam']) ?>"
                data-ad="<?= e($s['ad']) ?>"
                data-adres="<?= e($s['adres']) ?>"
                data-yol-tarifi="<?= e($s['yol_tarifi']) ?>">
          <?= e($s['ad']) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="map__frame" data-harita-sekmeli>
      <div class="map__canvas"
           data-harita-sekmeli-tuval
           data-enlem="<?= e((string) $ilk['enlem']) ?>"
           data-boylam="<?= e((string) $ilk['boylam']) ?>"
           data-ad="<?= e($ilk['ad']) ?>"
           role="img"
           aria-label="<?= e($ilk['ad']) ?> şubesi konumu haritada"></div>

      <div class="map__card">
        <div>
          <p class="eyebrow" data-harita-sekmeli-ad><?= e($ilk['ad']) ?></p>
          <p style="margin-top:var(--bosluk-2)" data-harita-sekmeli-adres><?= e($ilk['adres']) ?></p>
        </div>
        <a class="btn btn--primary btn--sm" data-harita-sekmeli-link href="<?= e($ilk['yol_tarifi']) ?>" target="_blank" rel="noopener">
          Google Maps’te Aç <span aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </div>
</section>
