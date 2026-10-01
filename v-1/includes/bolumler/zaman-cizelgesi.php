<?php
/** @var array $b */
$ogeler = $b['ogeler'] ?? [];
$son    = count($ogeler) - 1;
?>
<?= bolum_ac($b, 'timeline') ?>
  <div class="container">
    <?= bolum_basligi($b, 'orta') ?>
    <ol class="timeline__list">
      <?php foreach ($ogeler as $i => $o): ?>
        <li class="timeline__item<?= $i === $son ? ' timeline__item--highlight' : '' ?>" data-goster>
          <span class="timeline__dot" aria-hidden="true"></span>
          <div class="timeline__card">
            <span class="timeline__year"><?= e($o['yil'] ?? '') ?></span>
            <h3 class="timeline__title"><?= e($o['baslik'] ?? '') ?></h3>
            <?php if (!empty($o['metin'])): ?>
              <p class="timeline__text"><?= e($o['metin']) ?></p>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
