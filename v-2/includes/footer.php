</main>

<footer class="alt">
  <div class="konteyner">
    <div class="alt__izgara">
      <div>
        <p class="ust__logo">Boğaziçi</p>
        <p style="margin-top:var(--bosluk-3);color:color-mix(in oklab,var(--renk-birincil-ustu) 75%,transparent);font-size:var(--yazi-sm);max-width:34ch;">
          Üç şubede, aynı mutfak. Deniz ürünleri ve Türk mutfağı.
        </p>
      </div>

      <div>
        <h2 class="alt__baslik">Şubeler</h2>
        <ul class="alt__liste">
          <?php foreach (SUBELER as $s): ?>
            <li><a href="/subeler.php#sube-<?= e($s['slug']) ?>"><?= e($s['ad']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h2 class="alt__baslik">Menü</h2>
        <ul class="alt__liste">
          <li><a href="/menu.php">A la carte</a></li>
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
      <span><a href="/kvkk.php">KVKK</a> · <a href="/gizlilik.php">Gizlilik</a></span>
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
