<?php /** @var array $b */ ?>
<section class="alinti">
  <div class="konteyner konteyner--dar">
    <blockquote class="alinti__blok" data-reveal>
      <p class="alinti__metin"><?= e($b['metin']) ?></p>
      <?php if (!empty($b['kaynak'])): ?>
        <footer class="alinti__kaynak">— <?= e($b['kaynak']) ?></footer>
      <?php endif; ?>
    </blockquote>
  </div>
</section>
