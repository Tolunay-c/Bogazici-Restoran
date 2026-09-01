<?php /** @var array $b */ ?>
<section class="hero" aria-label="Giriş">
  <div class="hero__gorsel" aria-hidden="true">
    <img src="<?= e(gorsel_url($b['gorsel'], 2200)) ?>"
         alt=""
         width="2200" height="1237"
         loading="eager" fetchpriority="high" decoding="sync">
  </div>

  <div class="konteyner hero__ic">
    <p class="ustluk hero__ustluk" data-reveal><?= e($b['ustluk']) ?></p>
    <h1 class="hero__baslik" data-reveal><?= e($b['baslik']) ?></h1>
    <p class="hero__alt" data-reveal><?= e($b['alt_baslik']) ?></p>

    <?php if (!empty($b['butonlar'])): ?>
      <div class="hero__aksiyonlar" data-reveal>
        <?php foreach ($b['butonlar'] as $bt): ?>
          <a class="btn btn--<?= e($bt['tur'] ?? 'birincil') ?>" href="<?= e($bt['link']) ?>"><?= e($bt['yazi']) ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="hero__kaydir" aria-hidden="true">
    <span>Kaydırın</span>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M12 4v16M6 14l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>
</section>
