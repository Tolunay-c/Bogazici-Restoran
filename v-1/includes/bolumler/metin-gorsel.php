<?php
/** @var array $b */
$yon = ($b['yon'] ?? 'sag') === 'sol' ? 'sol' : 'sag';

/* İsteğe bağlı "gorsel_tam": fotoğraf kırpılmadan kendi oranında gösterilir */
$tam = !empty($b['gorsel_tam']);
$tamEn = 16; $tamBoy = 9; // yedek oran (dosya okunamazsa / URL ise)
if ($tam) {
    $g = (string) ($b['gorsel'] ?? '');
    if ($g !== '' && !preg_match('#^https?://#i', $g)) {
        $yol = __DIR__ . '/../../assets/img/' . $g;
        $boyut = is_file($yol) ? @getimagesize($yol) : false;
        if ($boyut && $boyut[0] > 0 && $boyut[1] > 0) {
            $tamEn = (int) $boyut[0];
            $tamBoy = (int) $boyut[1];
        }
    }
}
$gorselOpt = ['alt' => $b['gorsel_alt'] ?? '', 'odak' => $b['gorsel_odak'] ?? 'merkez'];
if ($tam) {
    $gorselOpt['en'] = $tamEn;
    $gorselOpt['boy'] = $tamBoy;
}
?>
<?= bolum_ac($b, 'metin-gorsel metin-gorsel--' . $yon . ($tam ? ' metin-gorsel--tam' : '')) ?>
  <div class="konteyner">
    <div class="metin-gorsel__izgara">
      <div class="metin-gorsel__metin" data-goster>
        <?= bolum_basligi($b) ?>
        <?php if (!empty($b['metin'])): ?>
          <div class="metin-akis"><p><?= nl2br(e($b['metin'])) ?></p></div>
        <?php endif; ?>
        <?php if (!empty($b['alinti'])): ?>
          <blockquote class="metin-gorsel__alinti"><?= e($b['alinti']) ?></blockquote>
        <?php endif; ?>
        <?php if ($btn = buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'ikincil')): ?>
          <div class="btn-grup"><?= $btn ?></div>
        <?php endif; ?>
      </div>

      <div class="metin-gorsel__gorsel gorsel-yuva"<?= $tam ? ' style="' . e('--oran:' . $tamEn . ' / ' . $tamBoy) . '"' : '' ?>>
        <?= gorsel($b['gorsel'] ?? '', $tam ? '(min-width:900px) 760px, 100vw' : '(min-width:900px) 1200px, 160vw', $gorselOpt) ?>
      </div>
    </div>
  </div>
</section>
