<?php
/** @var array $b */
$duzen = ($b['duzen'] ?? 'izgara') === 'yatay' ? 'yatay' : 'izgara';
?>
<?= bolum_ac($b, 'branch-list branch-list--' . ($duzen === 'yatay' ? 'row' : 'grid')) ?>
  <div class="container">
    <?= bolum_basligi($b) ?>

    <?php if ($duzen === 'yatay'): ?>

      <ul class="branch-row__list">
        <?php foreach (SUBELER as $s): ?>
          <li class="branch-row card--bordered" id="sube-<?= e($s['slug']) ?>" data-goster>
            <!-- Bilgi ÖNCE gelir: harita ancak adı okuduktan sonra
                 anlam kazanıyor. Görsel tarama sırası ad -> adres ->
                 aksiyon -> doğrulama (harita). -->
            <div class="branch-row__body">
              <div class="branch-row__top">
                <h3 class="branch-row__name">
                  <a href="/sube.php?s=<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a>
                </h3>
                <p class="branch-row__address"><?= e($s['adres']) ?></p>
                <p class="branch-row__hours"><?= e($s['saat']) ?></p>
                <?php if (!empty($s['not'])): ?>
                  <p class="branch__note"><span class="icon icon--sm" aria-hidden="true">free_breakfast</span><?= e($s['not']) ?></p>
                <?php endif; ?>

                <ul class="branch-row__zones">
                  <?php foreach ($s['bolgeler'] as $bolge): ?>
                    <li class="badge"><?= e($bolge) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>

              <div class="branch-row__actions">
                <a class="btn btn--primary" href="/rezervasyon.php?sube=<?= e($s['slug']) ?>">Rezervasyon yap</a>
                <a class="btn btn--secondary" href="/sube.php?s=<?= e($s['slug']) ?>">Şubeyi incele</a>
                <a class="btn btn--secondary" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi al</a>
              </div>
            </div>

            <div class="branch-row__map">
              <div class="map__canvas branch-row__canvas"
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

      <ul class="branch-list__list">
        <?php foreach (SUBELER as $s): ?>
          <li class="card card--bordered card--link" data-goster>
            <div class="card__image" style="--oran:4/3">
              <?= gorsel($s['gorsel'], '(min-width:900px) 760px, 160vw', ['alt' => $s['ad'] . ' şubesi']) ?>
            </div>
            <div class="card__body">
              <h3 class="card__title">
                <a class="card__link" href="/sube.php?s=<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a>
              </h3>
              <div class="branch__info">
                <span><?= e($s['adres']) ?></span>
                <a class="branch__phone" href="tel:<?= e($s['telefon']) ?>"><span class="icon icon--sm" aria-hidden="true">call</span><?= e($s['telefon_yazi']) ?></a>
                <?php if (!empty($s['not'])): ?>
                  <span class="branch__note"><span class="icon icon--sm" aria-hidden="true">free_breakfast</span><?= e($s['not']) ?></span>
                <?php endif; ?>
              </div>
            </div>
            <div class="card__actions branch__actions">
              <a class="btn btn--primary" href="/rezervasyon.php?sube=<?= e($s['slug']) ?>">Rezervasyon</a>
              <div class="branch__secondary">
                <a class="btn btn--secondary" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi</a>
                <?php if (!empty($s['paket_servis'])): ?>
                  <a class="btn btn--secondary" href="<?= e($s['paket_servis']) ?>">Paket servis</a>
                <?php endif; ?>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

    <?php endif; ?>
  </div>
</section>
