</main>

<footer class="site-footer">
  <div class="container">
    <div class="site-footer__grid">
      <div>
        <p class="site-header__logo" style="color:var(--notr-kum)"><?= e(SITE_ADI) ?></p>
        <p class="prose" style="margin-top:var(--bosluk-4);color:var(--metin-ters-ikincil);font-size:var(--yazi-sm)">
          1993’ten bugüne İzmir’de lezzet, kalite ve misafirperverliği aynı özenle sofralarınıza taşıyoruz.
        </p>
        <p class="site-footer__motto">İyi Ye, İyi Yaşa</p>
        <div class="site-footer__social">
          <a href="https://www.instagram.com/restaurantbogazici/" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="5"/>
              <circle cx="12" cy="12" r="4.2"/>
              <circle cx="17.2" cy="6.8" r="1.1" fill="currentColor" stroke="none"/>
            </svg>
          </a>
        </div>
      </div>

      <div>
        <h2 class="site-footer__title">Hızlı Erişim</h2>
        <ul class="site-footer__list">
          <li><a href="/">Ana Sayfa</a></li>
          <li><a href="/kurumsal.php">Kurumsal</a></li>
          <li><a href="/subeler.php">Şubelerimiz</a></li>
          <li><a href="/menu.php">Menü</a></li>
          <li><a href="/hizmetler.php">Hizmetler</a></li>
          <li><a href="/iletisim.php">İletişim</a></li>
          <?php if (REZERVASYON_AKTIF): ?><li><a href="/rezervasyon.php">Rezervasyon</a></li><?php endif; ?>
        </ul>
      </div>

      <div>
        <h2 class="site-footer__title">Şubelerimiz</h2>
        <ul class="site-footer__list">
          <?php foreach (SUBELER as $s): ?>
            <li>
              <a href="/subeler.php#sube-<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a>
              <?php if (sube_telefonlari($s)): ?>
                <span class="site-footer__branch-tel phone-line"><?= sube_telefon_satiri($s) ?></span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <ul class="site-footer__list" style="margin-top:var(--bosluk-5)">
          <li><a href="tel:+908508500850">0850 850 0850</a></li>
          <li><a href="mailto:info@bogazicirestaurant.com.tr">info@bogazicirestaurant.com.tr</a></li>
        </ul>
      </div>

      <div>
        <h2 class="site-footer__title">Kurumsal</h2>
        <ul class="site-footer__list">
          <li><a href="/ik.php">İnsan Kaynakları</a></li>
          <li><a href="/kvkk.php">KVKK Metni</a></li>
          <li><a href="/cerez.php">Çerez Aydınlatma Metni</a></li>
          <li><a href="/gizlilik.php">Gizlilik Politikası</a></li>
        </ul>
      </div>
    </div>

    <div class="site-footer__copyright">
      <span>© 2026 Boğaziçi Restaurant. Tüm Hakları Saklıdır.</span>
      <span><a href="/kvkk.php">KVKK</a> | <a href="/cerez.php">Çerez Politikası</a> | <a href="/gizlilik.php">Gizlilik Politikası</a></span>
    </div>
  </div>
</footer>

<!-- Mobil alt aksiyon çubuğu — dönüşümün büyük kısmı bu üçünden geliyor -->
<nav class="bottom-bar" aria-label="Hızlı işlemler">
  <a href="tel:+908508500850">
    <span class="icon icon--sm" aria-hidden="true">call</span>
    Ara
  </a>
  <a href="/subeler.php">
    <span class="icon icon--sm" aria-hidden="true">directions</span>
    Yol tarifi
  </a>
  <?php if (REZERVASYON_AKTIF): ?>
  <a href="/rezervasyon.php">
    <span class="icon icon--sm" aria-hidden="true">event_available</span>
    Rezervasyon
  </a>
  <?php else: ?>
  <a href="/menu.php">
    <span class="icon icon--sm" aria-hidden="true">restaurant_menu</span>
    Menü
  </a>
  <?php endif; ?>
</nav>

<dialog class="lightbox" id="lightbox" aria-label="Görsel önizleme">
  <div class="lightbox__inner">
    <button class="lightbox__close" type="button" data-lightbox-kapat>Kapat ✕</button>
    <img alt="">
  </div>
</dialog>

<script src="<?= VARLIK ?>/js/app.js?v=<?= SURUM ?>" defer></script>
</body>
</html>
