</main>

<footer class="alt">
  <div class="konteyner">
    <div class="alt__izgara">
      <div>
        <p class="ust__logo" style="color:var(--notr-kum)"><?= e(SITE_ADI) ?></p>
        <p class="metin-akis" style="margin-top:var(--bosluk-4);color:var(--metin-ters-ikincil);font-size:var(--yazi-sm)">
          1993’ten bugüne İzmir’de lezzet, kalite ve misafirperverliği aynı özenle sofralarınıza taşıyoruz.
        </p>
        <p class="alt__moto">İyi Ye, İyi Yaşa</p>
        <div class="alt__sosyal">
          <a href="#" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="5"/>
              <circle cx="12" cy="12" r="4.2"/>
              <circle cx="17.2" cy="6.8" r="1.1" fill="currentColor" stroke="none"/>
            </svg>
          </a>
          <a href="#" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
              <path d="M14.5 21v-7.5h2.5l.4-3H14.5V8.4c0-.87.24-1.46 1.5-1.46H17.5V4.35C17.24 4.32 16.36 4.24 15.34 4.24c-2.13 0-3.59 1.3-3.59 3.68V10.5H9.25v3h2.5V21"/>
            </svg>
          </a>
        </div>
      </div>

      <div>
        <h2 class="alt__baslik">Hızlı Erişim</h2>
        <ul class="alt__liste">
          <li><a href="/">Ana Sayfa</a></li>
          <li><a href="/kurumsal.php">Kurumsal</a></li>
          <li><a href="/subeler.php">Şubelerimiz</a></li>
          <li><a href="/menu.php">Menü</a></li>
          <li><a href="/hizmetler.php">Hizmetler</a></li>
          <li><a href="/iletisim.php">İletişim</a></li>
          <li><a href="/rezervasyon.php">Rezervasyon</a></li>
        </ul>
      </div>

      <div>
        <h2 class="alt__baslik">Şubelerimiz</h2>
        <ul class="alt__liste">
          <?php foreach (SUBELER as $s): ?>
            <li><a href="/sube.php?s=<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <ul class="alt__liste" style="margin-top:var(--bosluk-5)">
          <li><a href="tel:+908508500850">0850 850 0850</a></li>
          <li><a href="mailto:info@bogazicirestaurant.com.tr">info@bogazicirestaurant.com.tr</a></li>
        </ul>
      </div>

      <div>
        <h2 class="alt__baslik">Kurumsal</h2>
        <ul class="alt__liste">
          <li><a href="/ik.php">İnsan Kaynakları</a></li>
          <li><a href="/kvkk.php">KVKK Metni</a></li>
          <li><a href="/cerez.php">Çerez Aydınlatma Metni</a></li>
          <li><a href="/gizlilik.php">Gizlilik Politikası</a></li>
        </ul>
      </div>
    </div>

    <div class="alt__telif">
      <span>© 2026 Boğaziçi Restaurant. Tüm Hakları Saklıdır.</span>
      <span><a href="/kvkk.php">KVKK</a> | <a href="/cerez.php">Çerez Politikası</a> | <a href="/gizlilik.php">Gizlilik Politikası</a></span>
    </div>
  </div>
</footer>

<!-- Mobil alt aksiyon çubuğu — dönüşümün büyük kısmı bu üçünden geliyor -->
<nav class="altbar" aria-label="Hızlı işlemler">
  <a href="tel:+908508500850">
    <span class="ikon ikon--sm" aria-hidden="true">call</span>
    Ara
  </a>
  <a href="/subeler.php">
    <span class="ikon ikon--sm" aria-hidden="true">directions</span>
    Yol tarifi
  </a>
  <a href="/rezervasyon.php">
    <span class="ikon ikon--sm" aria-hidden="true">event_available</span>
    Rezervasyon
  </a>
</nav>

<dialog class="lightbox" id="lightbox" aria-label="Görsel önizleme">
  <div class="lightbox__ic">
    <button class="lightbox__kapat" type="button" data-lightbox-kapat>Kapat ✕</button>
    <img alt="">
  </div>
</dialog>

<script src="<?= VARLIK ?>/js/app.js?v=<?= SURUM ?>" defer></script>
</body>
</html>
