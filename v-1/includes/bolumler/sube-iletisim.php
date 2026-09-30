<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'sube-iletisim') ?>
  <div class="konteyner">
    <?= bolum_basligi($b) ?>
    <ul class="sube-iletisim__liste">
      <?php foreach (SUBELER as $s): ?>
        <li class="sube-iletisim__kart" data-goster>
          <div class="sube-iletisim__gorsel">
            <?= gorsel($s['gorsel'], '(min-width:900px) 380px, 100vw', ['alt' => $s['ad'] . ' şubesi']) ?>
          </div>
          <div class="sube-iletisim__govde">
            <h3 class="sube-iletisim__ad"><?= e($s['ad']) ?></h3>
            <p class="sube-iletisim__adres"><?= e($s['adres']) ?></p>
            <div class="sube-iletisim__bilgi">
              <a href="tel:<?= e($s['telefon']) ?>">
                <span class="ikon ikon--sm" aria-hidden="true">call</span><?= e($s['telefon_yazi']) ?>
              </a>
              <a href="mailto:<?= e($s['eposta']) ?>">
                <span class="ikon ikon--sm" aria-hidden="true">mail</span><?= str_replace('@', '@<wbr>', e($s['eposta'])) ?>
              </a>
            </div>
            <div class="sube-iletisim__aksiyon">
              <a class="btn btn--ikincil btn--sm" href="<?= e($s['yol_tarifi']) ?>" target="_blank" rel="noopener">Yol tarifi al</a>
              <?php if (!empty($s['paket_servis'])): ?>
                <a class="btn btn--ikincil btn--sm" href="<?= e($s['paket_servis']) ?>">Paket servis</a>
              <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
