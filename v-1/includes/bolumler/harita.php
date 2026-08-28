<?php
/** @var array $b */
$s = $b['sube'] ?? SUBELER[0];
?>
<?= bolum_ac($b, 'harita') ?>
  <div class="konteyner">
    <?= bolum_basligi($b) ?>
    <div class="harita__cerceve">
      <div class="harita__tuval"
           data-harita
           data-enlem="<?= e((string) $s['enlem']) ?>"
           data-boylam="<?= e((string) $s['boylam']) ?>"
           data-ad="<?= e($s['ad']) ?>"
           data-adres="<?= e($s['adres']) ?>"
           role="img"
           aria-label="<?= e($s['ad']) ?> şubesi konumu haritada"></div>

      <div class="harita__kart">
        <div>
          <p class="ustluk"><?= e($s['ad']) ?></p>
          <p style="margin-top:var(--bosluk-2)"><?= e($s['adres']) ?></p>
        </div>
        <p class="metin-ikincil" style="font-size:var(--yazi-sm)"><?= e($s['saat']) ?></p>
        <div class="sube__aksiyon">
          <a class="btn btn--birincil btn--sm" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi</a>
          <a class="btn btn--duz" href="tel:<?= e($s['telefon']) ?>"><?= e($s['telefon_yazi']) ?></a>
        </div>
      </div>
    </div>
  </div>
</section>
