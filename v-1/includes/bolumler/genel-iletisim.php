<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'genel-iletisim') ?>
  <div class="konteyner genel-iletisim__ic">
    <?= bolum_basligi($b, 'orta') ?>
    <div class="genel-iletisim__bilgi">
      <a class="genel-iletisim__deger" href="tel:<?= e($b['telefon'] ?? '') ?>"><?= e($b['telefon_yazi'] ?? '') ?></a>
      <a class="genel-iletisim__deger" href="mailto:<?= e($b['eposta'] ?? '') ?>"><?= e($b['eposta'] ?? '') ?></a>
    </div>
  </div>
</section>
