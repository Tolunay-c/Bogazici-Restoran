<?php
/** @var array $b */

/** Basit stroke SVG glyph'leri — Phosphor benzeri, tek çizgi. */
$deger_ikon = static function (string $ad): string {
    return match ($ad) {
        'balik'  => '<path d="M3 12c2-3 6-5 10-5s7 2 9 5c-2 3-5 5-9 5s-8-2-10-5zM17 10l4-2v8l-4-2M7 12h.01" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'terazi' => '<path d="M12 3v18M8 21h8M4 7h16M8 7l-3 6h6zM16 7l-3 6h6z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'yaprak' => '<path d="M11 21c-1-7 2-13 8-16 3 5 2 15-3 17-3 1-5 0-5-1zM5 21c1-4 3-7 6-9" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'el'     => '<path d="M8 13V4a2 2 0 114 0v6M12 10V3a2 2 0 114 0v9M16 12V5a2 2 0 114 0v11a6 6 0 01-12 0v-3a2 2 0 114 0" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        default  => '',
    };
};
?>
<section class="degerler">
  <div class="konteyner">

    <header class="bolum-basligi bolum-basligi--merkez" data-reveal>
      <?php if (!empty($b['ustluk'])): ?>
        <p class="ustluk"><?= e($b['ustluk']) ?></p>
      <?php endif; ?>
      <h2 class="bolum-basligi__baslik"><?= e($b['baslik']) ?></h2>
    </header>

    <div class="degerler__izgara">
      <?php foreach ($b['ogeler'] as $d): ?>
        <article class="deger" data-reveal>
          <div class="deger__ikon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><?= $deger_ikon($d['ikon']) ?></svg>
          </div>
          <h3 class="deger__baslik"><?= e($d['baslik']) ?></h3>
          <p class="deger__metin"><?= e($d['metin']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

  </div>
</section>
