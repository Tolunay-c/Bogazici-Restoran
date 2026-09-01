<?php
/** @var array $b */
$kategoriler = [
    'tumu'     => 'Tümü',
    'yemek'    => 'Yemek',
    'mekan'    => 'Mekân',
    'etkinlik' => 'Etkinlik',
];
?>
<section class="galeri" data-galeri>
  <div class="konteyner">

    <div class="galeri-filtre" role="toolbar" aria-label="Kategori filtresi" data-reveal>
      <?php foreach ($kategoriler as $anahtar => $etiket): ?>
        <button
          type="button"
          class="galeri-filtre__btn"
          data-kategori="<?= e($anahtar) ?>"
          aria-pressed="<?= $anahtar === 'tumu' ? 'true' : 'false' ?>"
        ><?= e($etiket) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="galeri-izgara" data-galeri-izgara>
      <?php foreach ($b['ogeler'] as $oge): ?>
        <button
          type="button"
          class="galeri-oge"
          data-kategori="<?= e($oge['kategori']) ?>"
          data-lightbox="<?= e(gorsel_url($oge['dosya'], 2200)) ?>"
          data-altyazi="<?= e($oge['altyazi']) ?>"
          aria-label="Büyüt: <?= e($oge['alt']) ?>"
        >
          <img src="<?= e(gorsel_url($oge['dosya'], 960)) ?>"
               alt="<?= e($oge['alt']) ?>"
               loading="lazy" decoding="async">
        </button>
      <?php endforeach; ?>
    </div>

    <p class="galeri-sayac" aria-live="polite" data-galeri-sayac></p>

  </div>
</section>

<dialog class="lightbox" id="lightbox" aria-label="Görsel önizleme">
  <button type="button" class="lightbox__kapat" data-lightbox-kapat aria-label="Kapat">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20" aria-hidden="true">
      <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/>
    </svg>
  </button>
  <div class="lightbox__ic">
    <img alt="" data-lightbox-img>
    <p class="lightbox__altyazi" data-lightbox-altyazi></p>
  </div>
</dialog>
