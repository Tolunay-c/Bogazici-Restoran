<?php
/** @var array $b */

$hizmet_ikon = static function (string $ad): string {
    return match ($ad) {
        'takim' => '<path d="M4 7h16v13H4zM9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M4 12h16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'yuzuk' => '<circle cx="12" cy="15" r="6" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M9 4l1 4h4l1-4M10 8l2 2 2-2" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'kutu'  => '<path d="M3 7l9-4 9 4v10l-9 4-9-4V7zM3 7l9 4 9-4M12 11v10" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'kalem' => '<path d="M15 3l6 6-12 12H3v-6L15 3zM13 5l6 6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        default => '',
    };
};
?>
<section class="hizmet-serit">
  <div class="konteyner">
    <div class="hizmet-serit__izgara">
      <?php foreach ($b['ogeler'] as $h): ?>
        <article class="hizmet-serit__oge" data-reveal>
          <div class="hizmet-serit__ikon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><?= $hizmet_ikon($h['ikon']) ?></svg>
          </div>
          <h3 class="hizmet-serit__ad"><?= e($h['ad']) ?></h3>
          <p class="hizmet-serit__metin"><?= e($h['metin']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
