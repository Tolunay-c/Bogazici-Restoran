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

    <div class="rezervasyon__ic">

      <div class="rezervasyon__kolon-kroki">
        <?php $ilk = true; foreach (SUBELER as $s):
          $bolgeler = REZERVASYON_BOLGELER[$s['slug']] ?? [];
        ?>
          <div
            class="rezervasyon__panel"
            role="tabpanel"
            id="sube-panel-<?= e($s['slug']) ?>"
            aria-labelledby="sube-tab-<?= e($s['slug']) ?>"
            data-sube="<?= e($s['slug']) ?>"
            <?= $ilk ? '' : 'hidden' ?>>

            <div class="rezervasyon__gorunum" role="tablist" aria-label="Görünüm">
              <button
                class="rezervasyon__gorunum-btn rezervasyon__gorunum-btn--secili"
                type="button"
                role="tab"
                aria-selected="true"
                data-gorunum="kroki">Kroki</button>
              <button
                class="rezervasyon__gorunum-btn"
                type="button"
                role="tab"
                aria-selected="false"
                data-gorunum="liste">Liste</button>
            </div>

            <div class="rezervasyon__kroki" data-gorunum-panel="kroki">
              <svg viewBox="0 0 800 600" class="rez-kroki" aria-label="<?= e($s['ad']) ?> şube krokisi" role="group">
                <rect x="16" y="16" width="768" height="568" rx="6" class="rez-kroki__cerceve" />
                <?php foreach ($bolgeler as $z):
                  [$x, $y, $w, $h] = $z['yerlesim'];
                  $dolu   = $z['musait'] <= 0;
                  $cx = $x + $w / 2;
                  $cy = $y + $h / 2;
                ?>
                  <g class="rez-kroki__bolge<?= $dolu ? ' rez-kroki__bolge--dolu' : '' ?>"
                     data-bolge-id="<?= e($z['id']) ?>"
                     data-bolge-ad="<?= e($z['ad']) ?>"
                     data-bolge-musait="<?= (int) $z['musait'] ?>"
                     role="button"
                     tabindex="<?= $dolu ? '-1' : '0' ?>"
                     aria-pressed="false"
                     aria-disabled="<?= $dolu ? 'true' : 'false' ?>"
                     aria-label="<?= e($z['ad']) ?>. <?= $dolu ? 'Dolu.' : e($z['musait']) . ' masa müsait.' ?>">
                    <rect x="<?= $x ?>" y="<?= $y ?>" width="<?= $w ?>" height="<?= $h ?>" rx="4" class="rez-kroki__zemin" />
                    <foreignObject x="<?= $x ?>" y="<?= $y ?>" width="<?= $w ?>" height="<?= $h ?>">
                      <div xmlns="http://www.w3.org/1999/xhtml" class="rez-kroki__etiket">
                        <span class="ikon rez-kroki__ikon" aria-hidden="true"><?= e($z['ikon']) ?></span>
                        <span class="rez-kroki__ad"><?= e($z['ad']) ?></span>
                        <span class="rez-kroki__durum">
                          <?= $dolu ? 'Dolu' : ((int) $z['musait']) . ' masa müsait' ?>
                        </span>
                      </div>
                    </foreignObject>
                  </g>
                <?php endforeach; ?>
              </svg>
            </div>

            <ul class="rezervasyon__liste" data-gorunum-panel="liste" hidden>
              <?php foreach ($bolgeler as $z):
                $dolu = $z['musait'] <= 0;
              ?>
                <li>
                  <button
                    class="rezervasyon__liste-btn"
                    type="button"
                    data-bolge-id="<?= e($z['id']) ?>"
                    data-bolge-ad="<?= e($z['ad']) ?>"
                    data-bolge-musait="<?= (int) $z['musait'] ?>"
                    aria-pressed="false"
                    <?= $dolu ? 'disabled aria-disabled="true"' : '' ?>>
                    <span class="ikon" aria-hidden="true"><?= e($z['ikon']) ?></span>
                    <span class="rezervasyon__liste-ad"><?= e($z['ad']) ?></span>
                    <span class="rezervasyon__liste-durum">
                      <?= $dolu ? 'Dolu' : ((int) $z['musait']) . ' masa müsait' ?>
                    </span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>

            <div class="rezervasyon__lejant" aria-hidden="true">
              <span class="rez-lejant"><span class="rez-lejant__nokta rez-lejant__nokta--musait"></span>Müsait</span>
              <span class="rez-lejant"><span class="rez-lejant__nokta rez-lejant__nokta--secili"></span>Seçili</span>
              <span class="rez-lejant"><span class="rez-lejant__nokta rez-lejant__nokta--dolu"></span>Dolu</span>
            </div>
            <p class="rezervasyon__ipucu">Kroki temsili, gerçek yerleşim şubede farklılık gösterebilir.</p>
          </div>
        <?php $ilk = false; endforeach; ?>
      </div>

      <form class="rezervasyon__form" method="post" action="/rezervasyon-gonder.php" novalidate data-hazir="false">
        <div class="rezervasyon__secim" aria-live="polite" data-duyuru>
          <p class="ustluk">Seçili bölge</p>
          <p class="rezervasyon__secim-ad" data-secim-ad>— henüz seçilmedi —</p>
          <p class="rezervasyon__secim-ipucu" data-secim-ipucu>Devam etmek için bir bölge seçin.</p>
        </div>

        <input type="hidden" name="sube"  value="<?= e(SUBELER[0]['slug']) ?>" data-secili-sube>
        <input type="hidden" name="bolge" value="" data-secili-bolge>

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
                  <span class="ikon" aria-hidden="true">remove</span>
                </button>
                <input class="sayac__girdi" type="number" id="rez-kisi" name="kisi" min="1" max="12" value="2" inputmode="numeric">
                <button type="button" class="sayac__btn" data-sayac-arti aria-label="Kişi sayısını arttır">
                  <span class="ikon" aria-hidden="true">add</span>
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
