<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'contact-info') ?>
  <div class="container contact-info__inner">
    <?= bolum_basligi($b, 'orta') ?>
    <div class="contact-info__info">
      <a class="contact-info__value" href="tel:<?= e($b['telefon'] ?? '') ?>"><?= e($b['telefon_yazi'] ?? '') ?></a>
      <a class="contact-info__value" href="mailto:<?= e($b['eposta'] ?? '') ?>"><?= e($b['eposta'] ?? '') ?></a>
    </div>
  </div>
</section>
