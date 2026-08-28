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

      <ol class="rezervasyon-ozet">
        <li class="rezervasyon-ozet__satir"><span>1. Şube</span><span class="metin-ikincil">Alsancak · Çeşme · Karşıyaka</span></li>
        <li class="rezervasyon-ozet__satir"><span>2. Bölge</span><span class="metin-ikincil">Kroki üzerinden seçim</span></li>
        <li class="rezervasyon-ozet__satir"><span>3. Tarih ve saat</span><span class="metin-ikincil">Dolu saatler kapalı görünür</span></li>
        <li class="rezervasyon-ozet__satir"><span>4. Bilgileriniz</span><span class="metin-ikincil">Ad, telefon, kişi sayısı</span></li>
        <li class="rezervasyon-ozet__satir"><span>5. Onay</span><span class="metin-ikincil">SMS ile anında teyit</span></li>
      </ol>
    </div>
  </div>
</section>
