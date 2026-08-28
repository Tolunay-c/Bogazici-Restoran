<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'iletisim') ?>
  <div class="konteyner">
    <div class="iletisim__ic">
      <div class="iletisim__yan">
        <?= bolum_basligi($b) ?>
        <?php if (!empty($b['metin'])): ?>
          <p class="metin-ikincil"><?= e($b['metin']) ?></p>
        <?php endif; ?>

        <ul class="iletisim__subeler">
          <?php foreach (SUBELER as $s): ?>
            <li>
              <p class="ustluk"><?= e($s['ad']) ?></p>
              <p class="metin-ikincil"><?= e($s['adres']) ?></p>
              <a class="btn btn--duz" href="tel:<?= e($s['telefon']) ?>"><?= e($s['telefon_yazi']) ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <form class="iletisim__form form-izgara" method="post" action="/iletisim-gonder.php" novalidate>
        <div class="form-izgara form-izgara--iki">
          <div class="alan">
            <label class="alan__etiket" for="ad">Ad soyad</label>
            <input class="girdi" type="text" id="ad" name="ad" autocomplete="name" required>
          </div>
          <div class="alan">
            <label class="alan__etiket" for="tel">Telefon</label>
            <input class="girdi" type="tel" id="tel" name="telefon" inputmode="tel" autocomplete="tel" required>
          </div>
        </div>

        <div class="alan">
          <label class="alan__etiket" for="eposta">E-posta</label>
          <input class="girdi" type="email" id="eposta" name="eposta" autocomplete="email">
        </div>

        <div class="alan">
          <label class="alan__etiket" for="mesaj">Mesajınız</label>
          <textarea class="metin-alani" id="mesaj" name="mesaj" required></textarea>
        </div>

        <div class="onay">
          <input type="checkbox" id="kvkk" name="kvkk" required>
          <label class="onay__metin" for="kvkk">
            <a href="/kvkk.php">KVKK aydınlatma metnini</a> okudum, bilgilerimin işlenmesini onaylıyorum.
          </label>
        </div>

        <button class="btn btn--birincil" type="submit">Gönder</button>
      </form>
    </div>
  </div>
</section>
