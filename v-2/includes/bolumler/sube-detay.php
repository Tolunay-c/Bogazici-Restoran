<?php
/** @var array $b */
$sube = sube_bul((string)($b['slug'] ?? ''));
$yon  = ($b['yon'] ?? 'sag') === 'sol' ? 'sol' : 'sag';
?>
<section class="sube-detay" data-yon="<?= e($yon) ?>" id="sube-<?= e($sube['slug']) ?>">
  <div class="konteyner">
    <div class="sube-detay__izgara">

      <figure class="sube-detay__gorsel" data-reveal>
        <img src="<?= e(gorsel_url($sube['gorsel'], 1440)) ?>"
             alt="<?= e($sube['ad'] . ' şubesi') ?>"
             width="1440" height="1080"
             loading="lazy" decoding="async">
      </figure>

      <div class="sube-detay__ic" data-reveal>
        <?php if (!empty($b['numara'])): ?>
          <p class="hikaye__numara" aria-hidden="true"><?= e($b['numara']) ?></p>
        <?php endif; ?>
        <p class="ustluk">Şube</p>
        <h2 class="sube-detay__ad"><?= e($sube['ad']) ?></h2>
        <?php if (!empty($b['metin'])): ?>
          <p class="sube-detay__metin"><?= e($b['metin']) ?></p>
        <?php endif; ?>

        <dl class="sube-detay__meta">
          <div class="sube-detay__meta__oge">
            <dt class="ustluk">Adres</dt>
            <dd><?= e($sube['adres']) ?></dd>
          </div>
          <div class="sube-detay__meta__oge">
            <dt class="ustluk">Saat</dt>
            <dd><?= e($sube['saat']) ?></dd>
          </div>
          <div class="sube-detay__meta__oge">
            <dt class="ustluk">Telefon</dt>
            <dd><a href="tel:<?= e($sube['telefon']) ?>" class="baglanti-vurgu"><?= e($sube['telefon_yazi']) ?></a></dd>
          </div>
        </dl>

        <?php if (!empty($sube['bolgeler'])): ?>
          <div class="sube-detay__bolgeler">
            <p class="ustluk">Bölgeler</p>
            <ul>
              <?php foreach ($sube['bolgeler'] as $bg): ?>
                <li class="sube-detay__bolge"><?= e($bg['ad']) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <div class="sube-detay__aksiyonlar">
          <a class="btn btn--birincil" href="/rezervasyon.php">Rezervasyon</a>
          <?php if (!empty($sube['yol_tarifi'])): ?>
            <a class="btn btn--ikincil" href="<?= e($sube['yol_tarifi']) ?>" target="_blank" rel="noopener">
              <span>Yol tarifi</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14" aria-hidden="true">
                <path d="M7 17l10-10M8 7h9v9" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>
