<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'rakamlar') ?>
  <div class="konteyner">
    <div class="rakamlar__ic">
      <?php if (!empty($b['gorsel'])): ?>
        <div class="rakamlar__gorsel gorsel-yuva">
          <?= gorsel($b['gorsel'], '(min-width:900px) 46vw, 100vw', [
              'alt'  => $b['gorsel_alt'] ?? '',
              'odak' => $b['gorsel_odak'] ?? 'merkez',
          ]) ?>
        </div>
      <?php endif; ?>

      <div class="rakamlar__metin">
        <?= bolum_basligi($b) ?>
        <ul class="rakamlar__liste">
          <?php foreach (($b['ogeler'] ?? []) as $o): ?>
            <li class="rakamlar__oge" data-goster>
              <span class="rakamlar__sayi" data-sayac><?= e($o['sayi'] ?? '') ?></span>
              <span class="rakamlar__etiket"><?= e($o['etiket'] ?? '') ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
