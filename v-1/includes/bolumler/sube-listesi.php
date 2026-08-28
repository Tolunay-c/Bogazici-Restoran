<?php
/** @var array $b */
$duzen = ($b['duzen'] ?? 'izgara') === 'yatay' ? 'yatay' : 'izgara';
?>
<?= bolum_ac($b, 'sube-listesi sube-listesi--' . $duzen) ?>
  <div class="konteyner">
    <?= bolum_basligi($b) ?>

    <?php if ($duzen === 'yatay'): ?>

      <ul class="sube-yatay__liste">
        <?php foreach (SUBELER as $s): ?>
          <li class="sube-yatay kart--cerceveli" data-goster>
            <!-- Bilgi ÖNCE gelir: harita ancak adı okuduktan sonra
                 anlam kazanıyor. Görsel tarama sırası ad -> adres ->
                 aksiyon -> doğrulama (harita). -->
            <div class="sube-yatay__govde">
              <div class="sube-yatay__ust">
                <h3 class="sube-yatay__ad">
                  <a href="/sube.php?s=<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a>
                </h3>
                <p class="sube-yatay__adres"><?= e($s['adres']) ?></p>
                <p class="sube-yatay__saat"><?= e($s['saat']) ?></p>

                <ul class="sube-yatay__bolgeler">
                  <?php foreach ($s['bolgeler'] as $bolge): ?>
                    <li class="rozet"><?= e($bolge) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>

              <div class="sube-yatay__aksiyon">
                <a class="btn btn--birincil" href="/rezervasyon.php?sube=<?= e($s['slug']) ?>">Rezervasyon yap</a>
                <a class="btn btn--ikincil" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi al</a>
              </div>
            </div>

            <div class="sube-yatay__harita">
              <div class="harita__tuval sube-yatay__tuval"
                   data-harita
                   data-enlem="<?= e((string) $s['enlem']) ?>"
                   data-boylam="<?= e((string) $s['boylam']) ?>"
                   data-ad="<?= e($s['ad']) ?>"
                   data-adres="<?= e($s['adres']) ?>"
                   role="img"
                   aria-label="<?= e($s['ad']) ?> şubesi konumu haritada"></div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

    <?php else: ?>

      <ul class="sube-listesi__liste">
        <?php foreach (SUBELER as $s): ?>
          <li class="kart kart--cerceveli kart--link" data-goster>
            <div class="kart__gorsel" style="--oran:4/3">
              <?= gorsel($s['gorsel'], '(min-width:900px) 360px, 100vw', ['alt' => $s['ad'] . ' şubesi']) ?>
            </div>
            <div class="kart__govde">
              <h3 class="kart__baslik">
                <a class="kart__baglanti" href="/sube.php?s=<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a>
              </h3>
              <div class="sube__bilgi">
                <span><?= e($s['adres']) ?></span>
                <span><?= e($s['saat']) ?></span>
                <span><?= e(implode(' · ', $s['bolgeler'])) ?></span>
              </div>
            </div>
            <div class="kart__ek sube__aksiyon">
              <a class="btn btn--birincil" href="/rezervasyon.php?sube=<?= e($s['slug']) ?>">Bu şubede yer ayır</a>
              <a class="btn btn--duz" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi al →</a>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

    <?php endif; ?>
  </div>
</section>
