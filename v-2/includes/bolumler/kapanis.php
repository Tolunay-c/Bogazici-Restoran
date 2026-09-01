<?php /** @var array $b */ ?>
<section class="kapanis">
  <div class="konteyner">
    <div class="kapanis__ic" data-reveal>
      <?php if (!empty($b['numara'])): ?>
        <p class="hikaye__numara hikaye__numara--merkez" aria-hidden="true"><?= e($b['numara']) ?></p>
      <?php endif; ?>
      <p class="ustluk"><?= e($b['ustluk']) ?></p>
      <h2 class="kapanis__baslik"><?= e($b['baslik']) ?></h2>
      <?php if (!empty($b['alt_baslik'])): ?>
        <p class="kapanis__alt"><?= e($b['alt_baslik']) ?></p>
      <?php endif; ?>
      <div class="kapanis__aksiyon">
        <a class="btn btn--birincil" href="<?= e($b['buton_link']) ?>"><?= e($b['buton_yazi']) ?></a>
      </div>
    </div>
  </div>
</section>
