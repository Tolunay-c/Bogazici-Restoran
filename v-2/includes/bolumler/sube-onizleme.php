<?php
/** @var array $b */
$varyant = ($b['varyant'] ?? 'anasayfa') === 'iletisim' ? 'iletisim' : 'anasayfa';
?>
<section class="subeler subeler--<?= e($varyant) ?>">
  <div class="konteyner">

    <header class="bolum-basligi bolum-basligi--merkez" data-reveal>
      <?php if (!empty($b['numara'])): ?>
        <p class="hikaye__numara hikaye__numara--merkez" aria-hidden="true"><?= e($b['numara']) ?></p>
      <?php endif; ?>
      <p class="ustluk"><?= e($b['ustluk']) ?></p>
      <h2 class="bolum-basligi__baslik"><?= e($b['baslik']) ?></h2>
      <?php if (!empty($b['alt_baslik'])): ?>
        <p class="bolum-basligi__alt"><?= e($b['alt_baslik']) ?></p>
      <?php endif; ?>
    </header>

    <div class="subeler__izgara">
      <?php foreach (SUBELER as $s): ?>
        <article class="sube-kart" data-reveal>
          <figure class="sube-kart__gorsel">
            <img src="<?= e(gorsel_url($s['gorsel'], 960)) ?>"
                 alt="<?= e($s['ad'] . ' şubesi') ?>"
                 width="960" height="720"
                 loading="lazy" decoding="async">
          </figure>
          <div class="sube-kart__ic">
            <h3 class="sube-kart__ad"><?= e(mb_strtoupper($s['ad'], 'UTF-8')) ?></h3>
            <div class="sube-kart__meta">
              <span><?= e($s['adres']) ?></span>
              <a href="tel:<?= e($s['telefon']) ?>" class="baglanti-vurgu"><?= e($s['telefon_yazi']) ?></a>
              <?php if ($varyant === 'iletisim' && !empty($s['eposta'])): ?>
                <a href="mailto:<?= e($s['eposta']) ?>" class="baglanti-vurgu"><?= e($s['eposta']) ?></a>
              <?php endif; ?>
            </div>
            <div class="sube-kart__aksiyonlar">
              <?php if ($varyant === 'anasayfa'): ?>
                <a class="btn btn--ikincil btn--sm" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol Tarifi</a>
                <a class="btn btn--birincil btn--sm" href="/v-2/rezervasyon.php">Rezervasyon</a>
                <?php if (!empty($s['paket_servis'])): ?>
                  <a class="btn btn--ikincil btn--sm" href="<?= e($s['paket_servis']) ?>">Paket Servis</a>
                <?php endif; ?>
              <?php else: ?>
                <a class="btn btn--ikincil btn--sm" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol Tarifi</a>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

  </div>
</section>
