<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'iletisim') ?>
  <div class="konteyner">
    <div class="iletisim__ic">
      <div class="iletisim__yan">
        <?= bolum_basligi($b) ?>
        <?php if (!empty($b['metin'])): ?>
          <p class="metin-ikincil"><?= e($b['metin']) ?></p>
        <?php endif; ?>
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

        <button class="btn btn--birincil" type="submit">Mesajı gönder</button>

        <p class="iletisim__form__rez-not">
          Rezervasyon işlemleri için Rezervasyon sayfamızı kullanabilirsiniz.
          <a class="btn btn--ikincil btn--sm" href="/rezervasyon.php">Rezervasyon yap</a>
        </p>
      </form>
    </div>
  </div>
</section>
