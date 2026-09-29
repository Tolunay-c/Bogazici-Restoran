<?php /** @var array $b */ ?>
<section class="genel-iletisim">
  <div class="konteyner konteyner--dar">
    <div class="genel-iletisim__ic" data-reveal>
      <?php if (!empty($b['ustluk'])): ?>
        <p class="ustluk"><?= e($b['ustluk']) ?></p>
      <?php endif; ?>
      <h2 class="genel-iletisim__baslik"><?= e($b['baslik']) ?></h2>
      <div class="genel-iletisim__satir">
        <a class="genel-iletisim__buyuk" href="tel:<?= e($b['telefon']) ?>"><?= e($b['telefon_yazi']) ?></a>
        <a class="genel-iletisim__buyuk" href="mailto:<?= e($b['eposta']) ?>"><?= e($b['eposta']) ?></a>
      </div>
    </div>
  </div>
</section>
