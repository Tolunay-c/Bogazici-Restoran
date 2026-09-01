<?php
/** @var array $b */
$yon = ($b['yon'] ?? 'sag') === 'sol' ? 'sol' : 'sag';
?>
<section class="hikaye" data-yon="<?= e($yon) ?>">
  <div class="konteyner">
    <div class="hikaye__izgara">

      <div class="hikaye__metin" data-reveal>
        <?php if (!empty($b['numara'])): ?>
          <p class="hikaye__numara" aria-hidden="true"><?= e($b['numara']) ?></p>
        <?php endif; ?>
        <?php if (!empty($b['ustluk'])): ?>
          <p class="ustluk"><?= e($b['ustluk']) ?></p>
        <?php endif; ?>
        <h2 class="hikaye__baslik"><?= e($b['baslik']) ?></h2>
        <?php if (!empty($b['metin'])): ?>
          <p class="hikaye__govde"><?= e($b['metin']) ?></p>
        <?php endif; ?>

        <?php if (!empty($b['metrik'])): ?>
          <dl class="hikaye__metrik">
            <?php foreach ($b['metrik'] as $m): ?>
              <div class="hikaye__metrik__oge">
                <dt class="hikaye__metrik__deger"><?= e($m['deger']) ?></dt>
                <dd class="hikaye__metrik__etiket"><?= e($m['etiket']) ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
        <?php endif; ?>

        <?php if (!empty($b['buton'])): ?>
          <div class="hikaye__aksiyon">
            <a class="btn btn--<?= e($b['buton']['tur'] ?? 'ikincil') ?>" href="<?= e($b['buton']['link']) ?>">
              <?= e($b['buton']['yazi']) ?>
            </a>
          </div>
        <?php endif; ?>
      </div>

      <?php if (!empty($b['gorsel'])): ?>
        <figure class="hikaye__gorsel" data-reveal>
          <img src="<?= e(gorsel_url($b['gorsel'], 1440)) ?>"
               alt="<?= e($b['gorsel_alt'] ?? '') ?>"
               width="1440" height="1800"
               loading="lazy" decoding="async">
        </figure>
      <?php endif; ?>

    </div>
  </div>
</section>
