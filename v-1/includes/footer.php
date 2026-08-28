</main>

<footer class="alt">
  <div class="konteyner">
    <div class="alt__izgara">
      <div>
        <p class="ust__logo" style="color:var(--notr-kum)"><?= e(SITE_ADI) ?></p>
        <p class="metin-akis" style="margin-top:var(--bosluk-4);color:var(--metin-ters-ikincil);font-size:var(--yazi-sm)">
          Üç şubede, aynı mutfak. Deniz ürünleri ve Türk mutfağı.
        </p>
      </div>

      <div>
        <h2 class="alt__baslik">Şubeler</h2>
        <ul class="alt__liste">
          <?php foreach (SUBELER as $s): ?>
            <li><a href="/sube.php?s=<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h2 class="alt__baslik">Menü</h2>
        <ul class="alt__liste">
          <li><a href="/menu.php?tip=alacarte">A la carte</a></li>
          <li><a href="/menu.php?tip=paket">Paket servis</a></li>
          <li><a href="/hizmetler.php">Hizmetler</a></li>
          <li><a href="/galeri.php">Galeri</a></li>
        </ul>
      </div>

      <div>
        <h2 class="alt__baslik">İletişim</h2>
        <ul class="alt__liste">
          <li><a href="tel:+902321234567">0232 123 45 67</a></li>
          <li><a href="mailto:info@bogazicirestaurant.com.tr">info@bogazicirestaurant.com.tr</a></li>
          <li><a href="/rezervasyon.php">Rezervasyon</a></li>
        </ul>
      </div>
    </div>

    <div class="alt__telif">
      <span>© <?= date('Y') ?> <?= e(SITE_ADI) ?></span>
      <span><a href="/kvkk.php">KVKK Aydınlatma Metni</a> · <a href="/gizlilik.php">Gizlilik</a></span>
    </div>
  </div>
</footer>

<!-- Mobil alt aksiyon çubuğu — dönüşümün büyük kısmı bu üçünden geliyor -->
<nav class="altbar" aria-label="Hızlı işlemler">
  <a href="tel:+902321234567">
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
