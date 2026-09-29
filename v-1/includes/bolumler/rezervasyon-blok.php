<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'rezervasyon-blok') ?>
  <div class="konteyner">
    <div class="rezervasyon-blok__ic">
      <div>
        <?= bolum_basligi($b) ?>
        <?php if (!empty($b['metin'])): ?>
          <p class="metin-akis metin-ikincil"><?= e($b['metin']) ?></p>
        <?php endif; ?>
        <div class="btn-grup" style="margin-top:var(--bosluk-6)">
          <?= buton($b['buton_yazi'] ?? '', $b['buton_link'] ?? '', 'birincil', 'btn--lg') ?>
        </div>
      </div>

      <?php $subeAdlari = implode(' · ', array_column(SUBELER, 'ad')); ?>
      <ol class="rezervasyon-ozet">
        <li class="rezervasyon-ozet__satir"><span>1. Şube</span><span class="metin-ikincil"><?= e($subeAdlari) ?></span></li>
        <li class="rezervasyon-ozet__satir"><span>2. Tarih ve saat</span><span class="metin-ikincil">Öğle veya akşam servisi</span></li>
        <li class="rezervasyon-ozet__satir"><span>3. Bilgileriniz</span><span class="metin-ikincil">Ad, telefon, kişi sayısı</span></li>
        <li class="rezervasyon-ozet__satir"><span>4. Onay</span><span class="metin-ikincil">Mesai saatinde teyit</span></li>
      </ol>
    </div>
  </div>
</section>
