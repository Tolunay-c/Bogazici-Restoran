</main>

<footer class="alt">
  <div class="konteyner">
    <div class="alt__izgara">

      <!-- 1. KOLON — MARKA -->
      <div class="alt__marka">
        <p class="ust__logo">Boğaziçi</p>
        <p class="alt__marka__slogan">1993’ten bugüne İzmir’de lezzet, kalite ve misafirperverliği aynı özenle sofralarınıza taşıyoruz.</p>
        <p class="alt__marka__moto">İyi Ye, İyi Yaşa</p>
        <div class="alt__sosyal">
          <a href="#" aria-label="Instagram" class="alt__sosyal__link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="4"/>
              <circle cx="12" cy="12" r="4"/>
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
            </svg>
          </a>
          <a href="#" aria-label="Facebook" class="alt__sosyal__link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20" aria-hidden="true">
              <path d="M14 8h3V4h-3c-2.2 0-4 1.8-4 4v2H7v4h3v8h4v-8h3l1-4h-4V8z" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- 2. KOLON — HIZLI ERİŞİM -->
      <div>
        <h2 class="alt__baslik">Hızlı Erişim</h2>
        <ul class="alt__liste">
          <li><a href="/v-2/">Ana Sayfa</a></li>
          <li><a href="/v-2/kurumsal.php">Kurumsal</a></li>
          <li><a href="/v-2/subeler.php">Şubelerimiz</a></li>
          <li><a href="/v-2/menu.php">Menü</a></li>
          <li><a href="/v-2/hizmetler.php">Hizmetler</a></li>
          <li><a href="/v-2/iletisim.php">İletişim</a></li>
          <li><a href="/v-2/rezervasyon.php">Rezervasyon</a></li>
        </ul>
      </div>

      <!-- 3. KOLON — ŞUBELER -->
      <div>
        <h2 class="alt__baslik">Şubelerimiz</h2>
        <ul class="alt__liste">
          <?php foreach (SUBELER as $s): ?>
            <li><a href="/v-2/subeler.php#sube-<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <div class="alt__iletisim">
          <a href="tel:+908508500850">0850 850 0850</a>
          <a href="mailto:info@bogazicirestaurant.com.tr">info@bogazicirestaurant.com.tr</a>
        </div>
      </div>

      <!-- 4. KOLON — KURUMSAL -->
      <div>
        <h2 class="alt__baslik">Kurumsal</h2>
        <ul class="alt__liste">
          <li><a href="/v-2/ik.php">İnsan Kaynakları</a></li>
          <li><a href="/v-2/kvkk.php">KVKK Metni</a></li>
          <li><a href="/v-2/cerez.php">Çerez Aydınlatma Metni</a></li>
          <li><a href="/v-2/gizlilik.php">Gizlilik Politikası</a></li>
        </ul>
      </div>

    </div>

    <div class="alt__telif">
      <span>© <?= date('Y') ?> Boğaziçi Restaurant. Tüm Hakları Saklıdır.</span>
      <span class="alt__telif__baglantilar">
        <a href="/v-2/kvkk.php">KVKK</a>
        <span aria-hidden="true">·</span>
        <a href="/v-2/cerez.php">Çerez Politikası</a>
        <span aria-hidden="true">·</span>
        <a href="/v-2/gizlilik.php">Gizlilik Politikası</a>
      </span>
    </div>
  </div>
</footer>

<!-- GSAP + ScrollTrigger CDN — defer sırası korunur. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<script src="<?= VARLIK ?>/js/app.js?v=<?= SURUM ?>" defer></script>
<?php if (!empty($sayfa_js)): ?>
  <script src="<?= VARLIK ?>/js/<?= e($sayfa_js) ?>?v=<?= SURUM ?>" defer></script>
<?php endif; ?>
</body>
</html>
