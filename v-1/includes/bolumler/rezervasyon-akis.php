<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'rezervasyon') ?>
  <div class="konteyner">
    <?= bolum_basligi($b, 'orta', 'h1') ?>

    <div class="rezervasyon__subeler" role="tablist" aria-label="Şube seçimi">
      <?php $ilk = true; foreach (SUBELER as $s): $secili = $ilk; ?>
        <button
          class="rezervasyon__sekme<?= $secili ? ' rezervasyon__sekme--secili' : '' ?>"
          role="tab"
          id="sube-tab-<?= e($s['slug']) ?>"
          aria-controls="sube-panel-<?= e($s['slug']) ?>"
          aria-selected="<?= $secili ? 'true' : 'false' ?>"
          tabindex="<?= $secili ? '0' : '-1' ?>"
          data-sube="<?= e($s['slug']) ?>"
          type="button">
          <?= e($s['ad']) ?>
        </button>
      <?php $ilk = false; endforeach; ?>
    </div>

    <div class="rezervasyon__ic rezervasyon__ic--tekli">

      <form class="rezervasyon__form rezervasyon__form--tekli" method="post" action="/rezervasyon-gonder.php" novalidate data-hazir="true">
        <input type="hidden" name="sube"  value="<?= e(SUBELER[0]['slug']) ?>" data-secili-sube>

        <header class="rezervasyon__form__basluk">
          <p class="ustluk">Masa Rezervasyonu</p>
          <h2 class="rezervasyon__form__baslik">Detayları paylaşın</h2>
          <p class="rezervasyon__form__yardim">
            Tarih, saat ve kişi sayısını seçin; ekibimiz rezervasyonunuzu mesai saatinde onaylayıp size dönüş yapar.
          </p>
        </header>

        <div class="rezervasyon__gerisi">
          <div class="form-izgara form-izgara--iki">
            <div class="alan">
              <label class="alan__etiket" for="rez-tarih">Tarih</label>
              <input class="girdi" type="date" id="rez-tarih" name="tarih" required autocomplete="off">
            </div>
            <div class="alan">
              <label class="alan__etiket" for="rez-kisi">Kişi sayısı</label>
              <div class="sayac">
                <button type="button" class="sayac__btn" data-sayac-eksi aria-label="Kişi sayısını azalt">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                    <path d="M5 12h14"/>
                  </svg>
                </button>
                <input class="sayac__girdi" type="number" id="rez-kisi" name="kisi" min="1" max="12" value="2" inputmode="numeric">
                <button type="button" class="sayac__btn" data-sayac-arti aria-label="Kişi sayısını arttır">
                  <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <fieldset class="rezervasyon__saatler">
            <legend class="alan__etiket">Saat</legend>
            <?php foreach (REZERVASYON_SAATLERI as $servis => $saatler): ?>
              <p class="ustluk rezervasyon__servis"><?= e($servis) ?></p>
              <div class="saat-cip__grup" role="radiogroup" aria-label="<?= e($servis) ?>">
                <?php foreach ($saatler as $saat): $id = 'rez-s-' . preg_replace('/[^0-9]/', '', $saat) . '-' . preg_replace('/[^a-z]/', '', strtolower($servis)); ?>
                  <label class="saat-cip">
                    <input type="radio" name="saat" value="<?= e($saat) ?>" id="<?= e($id) ?>">
                    <span><?= e($saat) ?></span>
                  </label>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </fieldset>

          <div class="alan">
            <label class="alan__etiket" for="rez-ad">Ad Soyad</label>
            <input class="girdi" type="text" id="rez-ad" name="ad" autocomplete="name" required>
          </div>

          <div class="alan">
            <label class="alan__etiket" for="rez-tel">Telefon</label>
            <input class="girdi" type="tel" id="rez-tel" name="telefon" inputmode="tel" autocomplete="tel" placeholder="0 5xx xxx xx xx" required>
          </div>

          <div class="alan">
            <label class="alan__etiket" for="rez-not">Not (isteğe bağlı)</label>
            <textarea class="metin-alani" id="rez-not" name="not" rows="3"></textarea>
            <p class="alan__ipucu">Alerjileriniz, özel gün, tercih ettiğiniz masa.</p>
          </div>

          <div class="onay">
            <input type="checkbox" id="rez-kvkk" name="kvkk" required>
            <label class="onay__metin" for="rez-kvkk">
              <a href="/kvkk.php">KVKK Aydınlatma Metni</a>'ni okudum, kişisel verilerimin rezervasyon amacıyla işlenmesine onay veriyorum.
            </label>
          </div>

          <button class="btn btn--birincil btn--tam btn--lg" type="submit">Rezervasyonu onayla</button>
        </div>
      </form>

    </div>
  </div>
</section>
