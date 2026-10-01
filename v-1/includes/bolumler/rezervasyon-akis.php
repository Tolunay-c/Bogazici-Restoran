<?php
/** @var array $b */
$secSube = (string) ($_GET['sube'] ?? '');
if (!in_array($secSube, array_column(SUBELER, 'slug'), true)) {
    $secSube = SUBELER[0]['slug'];
}
$rezForm = (string) ($_GET['form'] ?? '');
?>
<?= bolum_ac($b, 'reservation') ?>
  <div class="container">
    <?= bolum_basligi($b, 'orta', 'h1') ?>

    <div class="reservation__branches" role="tablist" aria-label="Şube seçimi">
      <?php foreach (SUBELER as $s): $secili = $s['slug'] === $secSube; ?>
        <button
          class="reservation__tab<?= $secili ? ' reservation__tab--selected' : '' ?>"
          role="tab"
          id="sube-tab-<?= e($s['slug']) ?>"
          aria-controls="sube-panel-<?= e($s['slug']) ?>"
          aria-selected="<?= $secili ? 'true' : 'false' ?>"
          tabindex="<?= $secili ? '0' : '-1' ?>"
          data-sube="<?= e($s['slug']) ?>"
          type="button">
          <?= e($s['ad']) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="reservation__inner reservation__inner--single">

      <form class="reservation__form reservation__form--single" method="post" action="/rezervasyon-gonder.php" id="rezervasyon-form" data-hazir="true">
        <?php if ($rezForm === 'tamam'): ?>
          <p class="form-alert form-alert--success" role="status">Rezervasyon talebiniz alındı. Ekibimiz en kısa sürede sizi arayarak rezervasyonunuzu teyit edecektir.</p>
        <?php elseif ($rezForm === 'hata'): ?>
          <p class="form-alert form-alert--error" role="alert">Rezervasyon talebiniz gönderilemedi. Lütfen tarih, saat ve iletişim bilgilerinizi kontrol edip tekrar deneyin.</p>
        <?php endif; ?>

        <header class="reservation__form-header">
          <p class="eyebrow">Masa Rezervasyonu</p>
          <h2 class="reservation__form-title">Detayları paylaşın</h2>
          <p class="reservation__form-help">
            Tarih, saat ve kişi sayısını seçin; ekibimiz rezervasyonunuzu mesai saatinde onaylayıp size dönüş yapar.
          </p>
        </header>

        <div class="reservation__rest">
          <!-- Şube seçimi üstteki sekmelerle iki yönlü bağlı; ziyaretçi nereye
               rezervasyon yaptığını formun içinde de görüp değiştirebilsin. -->
          <div class="field">
            <label class="field__label" for="rez-sube">Şube</label>
            <select class="select" id="rez-sube" name="sube" required data-secili-sube>
              <?php foreach (SUBELER as $s): ?>
                <option value="<?= e($s['slug']) ?>"<?= $s['slug'] === $secSube ? ' selected' : '' ?>><?= e($s['ad']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-grid form-grid--two">
            <div class="field">
              <label class="field__label" for="rez-tarih">Tarih</label>
              <input class="input" type="date" id="rez-tarih" name="tarih" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+90 days')) ?>" required autocomplete="off">
            </div>
            <div class="field">
              <label class="field__label" for="rez-kisi">Kişi sayısı</label>
              <div class="stepper">
                <button type="button" class="stepper__btn" data-sayac-eksi aria-label="Kişi sayısını azalt">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                    <path d="M5 12h14"/>
                  </svg>
                </button>
                <input class="stepper__input" type="number" id="rez-kisi" name="kisi" min="1" max="12" value="2" inputmode="numeric">
                <button type="button" class="stepper__btn" data-sayac-arti aria-label="Kişi sayısını arttır">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <fieldset class="reservation__times">
            <legend class="field__label">Saat</legend>
            <?php foreach (REZERVASYON_SAATLERI as $servis => $saatler): ?>
              <p class="eyebrow reservation__service"><?= e($servis) ?></p>
              <div class="time-chip__group" role="radiogroup" aria-label="<?= e($servis) ?>">
                <?php foreach ($saatler as $saat): $id = 'rez-s-' . preg_replace('/[^0-9]/', '', $saat) . '-' . preg_replace('/[^a-z]/', '', strtolower($servis)); ?>
                  <label class="time-chip">
                    <input type="radio" name="saat" value="<?= e($saat) ?>" id="<?= e($id) ?>" required>
                    <span><?= e($saat) ?></span>
                  </label>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </fieldset>

          <div class="field">
            <label class="field__label" for="rez-ad">Ad Soyad</label>
            <input class="input" type="text" id="rez-ad" name="ad" autocomplete="name" required>
          </div>

          <div class="field">
            <label class="field__label" for="rez-tel">Telefon</label>
            <input class="input" type="tel" id="rez-tel" name="telefon" inputmode="tel" autocomplete="tel" pattern="0[0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}" maxlength="14" title="Telefon numaranızı 0532 123 45 67 biçiminde girin" placeholder="05xx xxx xx xx" required>
          </div>

          <div class="field">
            <label class="field__label" for="rez-not">Not (isteğe bağlı)</label>
            <textarea class="textarea" id="rez-not" name="not" rows="3"></textarea>
            <p class="field__hint">Alerjileriniz, özel gün, tercih ettiğiniz masa.</p>
          </div>

          <div class="consent">
            <input type="checkbox" id="rez-kvkk" name="kvkk" required>
            <label class="consent__text" for="rez-kvkk">
              <a href="/kvkk.php">KVKK Aydınlatma Metni</a>'ni okudum, kişisel verilerimin rezervasyon amacıyla işlenmesine onay veriyorum.
            </label>
          </div>

          <input type="hidden" name="zaman" value="<?= time() ?>">
          <div class="honeypot" aria-hidden="true"><label for="rez-web-sitesi">Web siteniz</label><input type="text" id="rez-web-sitesi" name="web_sitesi" tabindex="-1" autocomplete="off"></div>

          <button class="btn btn--primary btn--full btn--lg" type="submit">Rezervasyon talebi gönder</button>
        </div>
      </form>

    </div>
  </div>
</section>
