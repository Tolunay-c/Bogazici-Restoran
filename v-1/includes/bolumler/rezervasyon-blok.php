<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'reservation-band') ?>
  <div class="container">
    <div class="reservation-band__inner">
      <div>
        <?= bolum_basligi($b) ?>
        <?php if (!empty($b['metin'])): ?>
          <p class="prose text-muted"><?= e($b['metin']) ?></p>
        <?php endif; ?>
        <div class="btn-group" style="margin-top:var(--bosluk-6)">
          <?= buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'birincil', 'btn--lg') ?>
          <?= buton($b['buton2_yazi'] ?? '', $b['buton2_link'] ?? '', 'ikincil', 'btn--lg') ?>
        </div>
      </div>

      <?php $subeAdlari = implode(' · ', array_column(SUBELER, 'ad')); ?>
      <ol class="reservation-summary">
        <li class="reservation-summary__row"><span>1. Şube</span><span class="text-muted"><?= e($subeAdlari) ?></span></li>
        <li class="reservation-summary__row"><span>2. Tarih ve saat</span><span class="text-muted">Öğle veya akşam servisi</span></li>
        <li class="reservation-summary__row"><span>3. Bilgileriniz</span><span class="text-muted">Ad, telefon, kişi sayısı</span></li>
        <li class="reservation-summary__row"><span>4. Onay</span><span class="text-muted">Mesai saatinde teyit</span></li>
      </ol>
    </div>
  </div>
</section>
