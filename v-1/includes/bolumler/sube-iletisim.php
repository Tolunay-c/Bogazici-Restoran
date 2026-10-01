<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'branch-contact') ?>
  <div class="container">
    <?= bolum_basligi($b) ?>
    <ul class="branch-contact__list">
      <?php foreach (SUBELER as $s): ?>
        <li class="branch-contact__card" data-goster>
          <div class="branch-contact__image">
            <?= gorsel($s['gorsel'], '(min-width:900px) 380px, 100vw', ['alt' => $s['ad'] . ' şubesi']) ?>
          </div>
          <div class="branch-contact__body">
            <h3 class="branch-contact__name"><?= e($s['ad']) ?></h3>
            <p class="branch-contact__address"><?= e($s['adres']) ?></p>
            <div class="branch-contact__info">
              <a href="tel:<?= e($s['telefon']) ?>">
                <span class="icon icon--sm" aria-hidden="true">call</span><?= e($s['telefon_yazi']) ?>
              </a>
              <a href="mailto:<?= e($s['eposta']) ?>">
                <span class="icon icon--sm" aria-hidden="true">mail</span><?= str_replace('@', '@<wbr>', e($s['eposta'])) ?>
              </a>
            </div>
            <div class="branch-contact__actions">
              <a class="btn btn--secondary btn--sm" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi al</a>
              <?php if (!empty($s['paket_servis'])): ?>
                <a class="btn btn--secondary btn--sm" href="<?= e($s['paket_servis']) ?>">Paket servis</a>
              <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
