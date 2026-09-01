<?php /** @var array $b */ ?>
<section class="zaman">
  <div class="konteyner">

    <header class="bolum-basligi bolum-basligi--merkez" data-reveal>
      <?php if (!empty($b['ustluk'])): ?>
        <p class="ustluk"><?= e($b['ustluk']) ?></p>
      <?php endif; ?>
      <h2 class="bolum-basligi__baslik"><?= e($b['baslik']) ?></h2>
    </header>

    <ol class="zaman__liste">
      <?php foreach ($b['ogeler'] as $o): ?>
        <li class="zaman__nokta" data-reveal>
          <p class="zaman__yil"><?= e($o['yil']) ?></p>
          <p class="zaman__olay"><?= e($o['olay']) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

  </div>
</section>
