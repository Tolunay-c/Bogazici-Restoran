<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'contact') ?>
  <div class="container">
    <div class="contact__inner">
      <div class="contact__aside">
        <?= bolum_basligi($b) ?>
        <?php if (!empty($b['metin'])): ?>
          <p class="text-muted"><?= e($b['metin']) ?></p>
        <?php endif; ?>
      </div>

      <form class="contact__form form-grid" method="post" action="/iletisim-gonder.php" id="iletisim-form">
        <?php if (($_GET['form'] ?? '') === 'tamam'): ?>
          <p class="form-alert form-alert--success" role="status">Mesajınız alındı. Ekibimiz en kısa sürede sizinle iletişime geçecektir.</p>
        <?php elseif (($_GET['form'] ?? '') === 'hata'): ?>
          <p class="form-alert form-alert--error" role="alert">Mesajınız gönderilemedi. Lütfen bilgilerinizi kontrol edip tekrar deneyin: telefon 0532 123 45 67 biçiminde olmalı, e-posta geçerli olmalı, mesaj en az 5 karakter olmalı.</p>
        <?php endif; ?>
        <div class="form-grid form-grid--two">
          <div class="field">
            <label class="field__label" for="ad">Ad soyad <span class="field__required" aria-hidden="true">*</span></label>
            <input class="input" type="text" id="ad" name="ad" autocomplete="name" required>
          </div>
          <div class="field">
            <label class="field__label" for="tel">Telefon <span class="field__required" aria-hidden="true">*</span></label>
            <input class="input" type="tel" id="tel" name="telefon" inputmode="tel" autocomplete="tel" pattern="0[0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}" maxlength="14" title="Telefon numaranızı 0532 123 45 67 biçiminde girin" placeholder="05xx xxx xx xx" required>
          </div>
        </div>

        <div class="field">
          <label class="field__label" for="eposta">E-posta <span class="field__required" aria-hidden="true">*</span></label>
          <input class="input" type="email" id="eposta" name="eposta" autocomplete="email" required>
        </div>

        <div class="field">
          <label class="field__label" for="mesaj">Mesajınız <span class="field__required" aria-hidden="true">*</span></label>
          <textarea class="textarea" id="mesaj" name="mesaj" required></textarea>
        </div>

        <div class="consent">
          <input type="checkbox" id="kvkk" name="kvkk" required>
          <label class="consent__text" for="kvkk">
            <a href="/kvkk.php">KVKK Aydınlatma Metni</a>'ni okudum ve kabul ediyorum.
          </label>
        </div>

        <input type="hidden" name="zaman" value="<?= time() ?>">
        <div class="honeypot" aria-hidden="true"><label for="web_sitesi">Web siteniz</label><input type="text" id="web_sitesi" name="web_sitesi" tabindex="-1" autocomplete="off"></div>

        <button class="btn btn--primary" type="submit">Mesajı gönder</button>

        <?php if (REZERVASYON_AKTIF): ?>
        <p class="contact__form-reservation-note">
          Rezervasyon işlemleri için Rezervasyon sayfamızı kullanabilirsiniz.
          <a class="btn btn--secondary btn--sm" href="/rezervasyon.php">Rezervasyon yap</a>
        </p>
        <?php endif; ?>
      </form>
    </div>
  </div>
</section>
