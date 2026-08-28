<?php
/** @var array $b */
$yon = ($b['yon'] ?? 'sag') === 'sol' ? 'sol' : 'sag';
?>
<?= bolum_ac($b, 'metin-gorsel metin-gorsel--' . $yon) ?>
  <div class="konteyner">
    <div class="metin-gorsel__izgara">
      <div class="metin-gorsel__metin" data-goster>
        <?= bolum_basligi($b) ?>
        <?php if (!empty($b['metin'])): ?>
          <div class="metin-akis"><p><?= nl2br(e($b['metin'])) ?></p></div>
        <?php endif; ?>
        <?php if ($btn = buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'ikincil')): ?>
          <div class="btn-grup"><?= $btn ?></div>
        <?php endif; ?>
      </div>

      <div class="metin-gorsel__gorsel gorsel-yuva">
        <?= gorsel($b['gorsel'] ?? '', '(min-width:900px) 460px, 100vw', [
            'alt' => $b['gorsel_alt'] ?? '',
            'odak' => $b['gorsel_odak'] ?? 'merkez',
        ]) ?>
      </div>
    </div>
  </div>
</section>
