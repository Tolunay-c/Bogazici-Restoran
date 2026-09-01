<?php /** @var array $b */ ?>
<section class="surec">
  <div class="konteyner">

    <header class="bolum-basligi bolum-basligi--merkez" data-reveal>
      <?php if (!empty($b['ustluk'])): ?>
        <p class="ustluk"><?= e($b['ustluk']) ?></p>
      <?php endif; ?>
      <h2 class="bolum-basligi__baslik"><?= e($b['baslik']) ?></h2>
    </header>

    <ol class="surec__liste">
      <?php foreach ($b['adimlar'] as $a): ?>
        <li class="surec__adim" data-reveal>
          <p class="surec__numara" aria-hidden="true"><?= e($a['numara']) ?></p>
          <h3 class="surec__baslik"><?= e($a['baslik']) ?></h3>
          <p class="surec__metin"><?= e($a['metin']) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

  </div>
</section>
