<?php
/** @var array $b */
$ogeler = $b['ogeler'] ?? [];
$son    = count($ogeler) - 1;
?>
<?= bolum_ac($b, 'zaman-cizelgesi') ?>
  <div class="konteyner">
    <?= bolum_basligi($b, 'orta') ?>
    <ol class="zaman-cizelgesi__liste">
      <?php foreach ($ogeler as $i => $o): ?>
        <li class="zaman-cizelgesi__oge<?= $i === $son ? ' zaman-cizelgesi__oge--vurgu' : '' ?>" data-goster>
          <span class="zaman-cizelgesi__nokta" aria-hidden="true"></span>
          <div class="zaman-cizelgesi__kart">
            <span class="zaman-cizelgesi__yil"><?= e($o['yil'] ?? '') ?></span>
            <h3 class="zaman-cizelgesi__baslik"><?= e($o['baslik'] ?? '') ?></h3>
            <?php if (!empty($o['metin'])): ?>
              <p class="zaman-cizelgesi__metin"><?= e($o['metin']) ?></p>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
