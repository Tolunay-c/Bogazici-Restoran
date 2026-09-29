<?php /** @var array $b */ ?>
<section class="kareler">
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

    <div class="kareler__izgara">
      <?php foreach (SUBELER as $s): ?>
        <a class="kare" href="/v-2/subeler.php#sube-<?= e($s['slug']) ?>" data-reveal>
          <figure class="kare__gorsel">
            <img src="<?= e(gorsel_url($s['gorsel'], 900)) ?>"
                 alt="<?= e($s['ad']) ?> şubesi"
                 width="900" height="900"
                 loading="lazy" decoding="async">
          </figure>
          <div class="kare__etiket">
            <span class="kare__ad"><?= e(mb_strtoupper($s['ad'], 'UTF-8')) ?></span>
            <span class="kare__ok" aria-hidden="true">→</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

  </div>
</section>
