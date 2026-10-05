<?php
/** @var array $b */
$s = $b['sube'] ?? SUBELER[0];
?>
<?= bolum_ac($b, 'map') ?>
  <div class="container">
    <?= bolum_basligi($b) ?>
    <div class="map__frame">
      <div class="map__canvas"
           data-harita
           data-enlem="<?= e((string) $s['enlem']) ?>"
           data-boylam="<?= e((string) $s['boylam']) ?>"
           data-ad="<?= e($s['ad']) ?>"
           data-adres="<?= e($s['adres']) ?>"
           role="img"
           aria-label="<?= e($s['ad']) ?> şubesi konumu haritada"></div>

      <div class="map__card">
        <div>
          <p class="eyebrow"><?= e($s['ad']) ?></p>
          <p style="margin-top:var(--bosluk-2)"><?= e($s['adres']) ?></p>
        </div>
        <p class="text-muted" style="font-size:var(--yazi-sm)"><?= e($s['saat']) ?></p>
        <div class="branch__actions">
          <a class="btn btn--primary btn--sm" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi</a>
          <?php if (sube_telefonlari($s)): ?>
            <p class="map__phones phone-line"><?= sube_telefon_satiri($s) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
