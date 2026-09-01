<?php
/** @var array $b */
$deger   = $b['deger']   ?? ['ad'=>'','eposta'=>'','tel'=>'','konu'=>'genel','mesaj'=>'','kvkk'=>false];
$hatalar = $b['hatalar'] ?? [];
$basari  = $b['basari']  ?? null;
$csrf    = $b['csrf']    ?? csrf_token();

$konular = [
    'genel'         => 'Genel bilgi',
    'rezervasyon'   => 'Rezervasyon',
    'etkinlik'      => 'Etkinlik / Catering',
    'basin'         => 'Basın',
    'geribildirim'  => 'Geri bildirim',
];

$merkez = SUBELER[0];
?>
<section class="iletisim" id="form">
  <div class="konteyner">

    <?php if ($basari): ?>
      <div class="uyari uyari--basari" role="status" style="margin-bottom:var(--bosluk-6)">
        <strong>Aldık!</strong><span><?= e($basari) ?></span>
      </div>
    <?php endif; ?>

    <?php if (!empty($hatalar['form'])): ?>
      <div class="uyari uyari--hata" role="alert" style="margin-bottom:var(--bosluk-6)">
        <?= e($hatalar['form']) ?>
      </div>
    <?php endif; ?>

    <div class="iletisim__izgara">

      <!-- FORM -->
      <form class="iletisim__form" method="post" action="/iletisim.php#form" novalidate data-reveal>
        <input type="hidden" name="csrf" value="<?= e($csrf) ?>">

        <div class="rez__ikili">
          <div class="alan">
            <label class="alan__etiket" for="il-ad">Ad Soyad</label>
            <input class="girdi" id="il-ad" name="ad" type="text"
              value="<?= e($deger['ad']) ?>"
              autocomplete="name"
              aria-describedby="il-ad-hata"
              <?= !empty($hatalar['ad']) ? 'aria-invalid="true"' : '' ?>>
            <p class="alan__hata" id="il-ad-hata" role="alert"><?= e($hatalar['ad'] ?? '') ?></p>
          </div>

          <div class="alan">
            <label class="alan__etiket" for="il-eposta">E-posta</label>
            <input class="girdi" id="il-eposta" name="eposta" type="email"
              value="<?= e($deger['eposta']) ?>"
              autocomplete="email"
              inputmode="email"
              aria-describedby="il-eposta-hata"
              <?= !empty($hatalar['eposta']) ? 'aria-invalid="true"' : '' ?>>
            <p class="alan__hata" id="il-eposta-hata" role="alert"><?= e($hatalar['eposta'] ?? '') ?></p>
          </div>
        </div>

        <div class="rez__ikili">
          <div class="alan">
            <label class="alan__etiket" for="il-tel">Telefon <span class="alan__etiket__ek">(isteğe bağlı)</span></label>
            <input class="girdi" id="il-tel" name="tel" type="tel"
              value="<?= e($deger['tel']) ?>"
              placeholder="0 5xx xxx xx xx"
              autocomplete="tel"
              inputmode="tel"
              aria-describedby="il-tel-hata"
              <?= !empty($hatalar['tel']) ? 'aria-invalid="true"' : '' ?>>
            <p class="alan__hata" id="il-tel-hata" role="alert"><?= e($hatalar['tel'] ?? '') ?></p>
          </div>

          <div class="alan">
            <label class="alan__etiket" for="il-konu">Konu</label>
            <select class="girdi" id="il-konu" name="konu">
              <?php foreach ($konular as $anahtar => $etiket): ?>
                <option value="<?= e($anahtar) ?>" <?= $deger['konu'] === $anahtar ? 'selected' : '' ?>>
                  <?= e($etiket) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <p class="alan__hata" role="alert"><?= e($hatalar['konu'] ?? '') ?></p>
          </div>
        </div>

        <div class="alan">
          <label class="alan__etiket" for="il-mesaj">Mesaj</label>
          <textarea class="metin-alani" id="il-mesaj" name="mesaj"
            rows="6"
            minlength="10"
            maxlength="2000"
            aria-describedby="il-mesaj-yardim il-mesaj-hata"
            <?= !empty($hatalar['mesaj']) ? 'aria-invalid="true"' : '' ?>><?= e($deger['mesaj']) ?></textarea>
          <p class="alan__yardim" id="il-mesaj-yardim">Kısa tutabilirsiniz. En az 10, en fazla 2000 karakter.</p>
          <p class="alan__hata" id="il-mesaj-hata" role="alert"><?= e($hatalar['mesaj'] ?? '') ?></p>
        </div>

        <div class="alan alan--onay">
          <label class="onay">
            <input type="checkbox" name="kvkk" value="1"
              <?= $deger['kvkk'] ? 'checked' : '' ?>
              <?= !empty($hatalar['kvkk']) ? 'aria-invalid="true" aria-describedby="il-kvkk-hata"' : '' ?>>
            <span>
              <a href="/kvkk.php" target="_blank" rel="noopener" class="baglanti-vurgu">KVKK Aydınlatma Metni</a>'ni
              okudum, mesajım için kişisel verilerimin işlenmesine onay veriyorum.
            </span>
          </label>
          <p class="alan__hata" id="il-kvkk-hata" role="alert"><?= e($hatalar['kvkk'] ?? '') ?></p>
        </div>

        <button type="submit" class="btn btn--birincil">Mesajı gönder</button>
      </form>

      <!-- SIDEBAR -->
      <aside class="iletisim__yan" data-reveal>
        <div class="iletisim__yan__oge">
          <span class="ustluk">Telefon</span>
          <a href="tel:<?= e($merkez['telefon']) ?>" class="iletisim__yan__buyuk"><?= e($merkez['telefon_yazi']) ?></a>
          <p class="iletisim__yan__not">Alsancak — merkez</p>
        </div>

        <div class="iletisim__yan__oge">
          <span class="ustluk">E-posta</span>
          <a href="mailto:info@bogazicirestaurant.com.tr">info@bogazicirestaurant.com.tr</a>
          <a href="mailto:etkinlik@bogazicirestaurant.com.tr" class="baglanti-vurgu">etkinlik@bogazicirestaurant.com.tr</a>
        </div>

        <div class="iletisim__yan__oge">
          <span class="ustluk">Adres</span>
          <p><?= e($merkez['adres']) ?></p>
        </div>

        <div class="iletisim__yan__oge">
          <span class="ustluk">Sosyal</span>
          <div class="iletisim__yan__sosyal">
            <a href="#" aria-label="Instagram" class="iletisim__yan__sosyal__link">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="4"/>
                <circle cx="12" cy="12" r="4"/>
                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
              </svg>
              <span>Instagram</span>
            </a>
            <a href="#" aria-label="Facebook" class="iletisim__yan__sosyal__link">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20" aria-hidden="true">
                <path d="M14 8h3V4h-3c-2.2 0-4 1.8-4 4v2H7v4h3v8h4v-8h3l1-4h-4V8z" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span>Facebook</span>
            </a>
          </div>
        </div>
      </aside>

    </div>
  </div>
</section>
