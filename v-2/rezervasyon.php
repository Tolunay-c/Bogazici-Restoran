<?php
require_once __DIR__ . '/config.php';

$aktif          = 'rezervasyon';
$sayfa_basligi  = 'Rezervasyon — ' . SITE_ADI;
$sayfa_aciklama = 'Şube ve bölge seçin, tarihinizi belirleyin. Rezervasyonunuz mesai saatinde onaylanır.';
$sayfa_js       = 'rezervasyon.js';

/* --------------------------------------------------------------
   POST işleme
   -------------------------------------------------------------- */
$hatalar = [];
$basari  = null;
$deger   = [
    'sube'    => $_POST['sube']    ?? 'alsancak',
    'bolge'   => $_POST['bolge']   ?? '',
    'tarih'   => $_POST['tarih']   ?? '',
    'kisi'    => (int)($_POST['kisi'] ?? 2),
    'saat'    => $_POST['saat']    ?? '',
    'ad'      => trim((string)($_POST['ad']  ?? '')),
    'tel'     => trim((string)($_POST['tel'] ?? '')),
    'not'     => trim((string)($_POST['not'] ?? '')),
    'kvkk'    => !empty($_POST['kvkk']),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_dogrula($_POST['csrf'] ?? null)) {
        $hatalar['form'] = 'Oturum süresi doldu, lütfen sayfayı yenileyin.';
    }

    $sube = null;
    foreach (SUBELER as $s) {
        if ($s['slug'] === $deger['sube']) { $sube = $s; break; }
    }
    if (!$sube) $hatalar['sube'] = 'Geçersiz şube.';

    if ($sube) {
        $bolgeGecerli = false;
        foreach ($sube['bolgeler'] as $b) {
            if ($b['id'] === $deger['bolge']) { $bolgeGecerli = true; break; }
        }
        if (!$bolgeGecerli) $hatalar['bolge'] = 'Lütfen bir bölge seçin.';
    }

    if ($deger['tarih'] === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $deger['tarih'])) {
        $hatalar['tarih'] = 'Geçerli bir tarih seçin.';
    } elseif ($deger['tarih'] < date('Y-m-d')) {
        $hatalar['tarih'] = 'Tarih bugünden önce olamaz.';
    }

    if ($deger['kisi'] < 1 || $deger['kisi'] > 12) $hatalar['kisi'] = 'Kişi sayısı 1–12 arası olmalı.';
    if (!in_array($deger['saat'], saat_hepsi(), true)) $hatalar['saat'] = 'Saat seçin.';
    if ($deger['ad'] === '' || mb_strlen($deger['ad']) < 3) $hatalar['ad'] = 'Ad soyad zorunlu.';
    if (!preg_match('/^[0-9+()\s\-]{10,20}$/', $deger['tel'])) $hatalar['tel'] = 'Telefon geçersiz.';
    if (mb_strlen($deger['not']) > 500) $hatalar['not'] = 'Not en fazla 500 karakter.';
    if (!$deger['kvkk']) $hatalar['kvkk'] = 'Devam etmek için KVKK onayı gerekli.';

    if (!$hatalar) {
        // Gerçek entegrasyon (DB / e-posta) burada. Şimdilik başarı mesajı.
        $basari = sprintf(
            '%s şubesi · %s bölgesi · %s, saat %s · %d kişi. Onay için sizi arayacağız.',
            $sube['ad'],
            array_values(array_filter($sube['bolgeler'], fn($b) => $b['id'] === $deger['bolge']))[0]['ad'] ?? '—',
            date('d.m.Y', strtotime($deger['tarih'])),
            $deger['saat'],
            $deger['kisi']
        );
        // Formu temizle
        $deger = ['sube' => $deger['sube']]
               + array_fill_keys(['bolge','tarih','saat','ad','tel','not'], '')
               + ['kisi' => 2, 'kvkk' => false];
    }
}

/* --------------------------------------------------------------
   SVG kroki — placeholder yerleşim (gerçek plan gelince değişir)
   Aynı 4 dikdörtgen düzeni her şubede kullanılıyor.
   -------------------------------------------------------------- */
function kroki_yerlesim(): array
{
    // viewBox 800×550. İç Salon dominant sol kolon; sağda üstten alta
    // Deniz Kenarı (küçük köşe), Teras, Bahçe. Deniz Kenarı dolduğunda
    // görsel olarak baskın olmasın diye en küçük alan.
    // id => [x, y, w, h]
    return [
        'ic-salon'     => [ 30,  30, 480, 490],
        'deniz-kenari' => [530,  30, 240, 120],
        'teras'        => [530, 170, 240, 180],
        'bahce'        => [530, 370, 240, 150],
    ];
}

function bolge_ikon_yolu(string $id): string
{
    // Phosphor-benzeri basit SVG glyph'ler
    switch ($id) {
        case 'deniz-kenari': return '<path d="M2 14c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2 2 2 4 2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>';
        case 'teras':        return '<rect x="3" y="4" width="18" height="12" rx="1" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M3 20l6-4M21 20l-6-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>';
        case 'bahce':        return '<path d="M12 3c-3 2-4 5-4 8a4 4 0 108 0c0-3-1-6-4-8zM12 15v6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>';
        default:             return '<rect x="4" y="6" width="16" height="12" rx="1" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M4 12h16" stroke="currentColor" stroke-width="1.6"/>';
    }
}

$saatGruplar = saat_secenekleri();
$saatEtiket  = ['ogle' => 'Öğle servisi', 'aksam' => 'Akşam servisi'];

/* Seçili bölgenin display adı ve açıklaması (POST-hata dönüşünde form üstünde göstermek için). */
$secili_ad     = '';
$secili_acikla = '';
if ($deger['bolge'] !== '') {
    $s_secili = null;
    foreach (SUBELER as $s) {
        if ($s['slug'] === $deger['sube']) { $s_secili = $s; break; }
    }
    if ($s_secili) {
        foreach ($s_secili['bolgeler'] as $b) {
            if ($b['id'] === $deger['bolge']) {
                $secili_ad     = $b['ad'];
                $secili_acikla = $b['aciklama'];
                break;
            }
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<section class="rez" data-rez>
  <div class="konteyner">

    <header class="bolum-basligi bolum-basligi--merkez">
      <p class="ustluk">Rezervasyon</p>
      <h1 class="bolum-basligi__baslik">Yeriniz hazır olsun</h1>
      <p class="bolum-basligi__alt">Şube ve bölge seçin, gerisi kolay. Rezervasyonunuz mesai saatinde onaylanır.</p>
    </header>

    <?php if ($basari): ?>
      <div class="uyari uyari--basari" role="status" style="margin-bottom:var(--bosluk-6)">
        <strong>Aldık!</strong>
        <span><?= e($basari) ?></span>
      </div>
    <?php endif; ?>

    <?php if (!empty($hatalar['form'])): ?>
      <div class="uyari uyari--hata" role="alert" style="margin-bottom:var(--bosluk-6)">
        <?= e($hatalar['form']) ?>
      </div>
    <?php endif; ?>

    <!-- Şube segmented -->
    <div class="rez__sube" role="tablist" aria-label="Şube seçin">
      <?php foreach (SUBELER as $i => $s):
        $sec = ($s['slug'] === $deger['sube']);
      ?>
        <button
          type="button"
          role="tab"
          class="rez__sube__btn"
          data-sube="<?= e($s['slug']) ?>"
          aria-selected="<?= $sec ? 'true' : 'false' ?>"
          aria-controls="panel-<?= e($s['slug']) ?>"
          tabindex="<?= $sec ? '0' : '-1' ?>"
        ><?= e($s['ad']) ?></button>
      <?php endforeach; ?>
    </div>

    <!-- Duyuru bölgesi (aria-live) -->
    <p class="gorunmez" aria-live="polite" data-duyuru></p>

    <div class="rez__izgara">

      <!-- SOL: kroki paneller -->
      <div>
        <?php foreach (SUBELER as $s):
          $aktifPanel = ($s['slug'] === $deger['sube']);
          $yerlesim = kroki_yerlesim();
        ?>
          <div
            class="rez__kroki"
            id="panel-<?= e($s['slug']) ?>"
            data-sube-panel="<?= e($s['slug']) ?>"
            role="tabpanel"
            aria-label="<?= e($s['ad']) ?> şubesi kat planı"
            <?= $aktifPanel ? '' : 'hidden' ?>
          >
            <div class="rez__gorunum" role="tablist" aria-label="Görünüm seçin">
              <button type="button" class="rez__gorunum__btn" data-gorunum-btn="kroki" aria-selected="true">Kroki</button>
              <button type="button" class="rez__gorunum__btn" data-gorunum-btn="liste" aria-selected="false">Liste</button>
            </div>

            <!-- SVG kroki -->
            <div class="rez__svg-sar">
              <svg class="rez__svg" viewBox="0 0 800 550" role="group" aria-label="<?= e($s['ad']) ?> kat planı — bölge seçmek için tıklayın">
                <?php foreach ($s['bolgeler'] as $b):
                  [$x, $y, $w, $h] = $yerlesim[$b['id']] ?? [40, 40, 200, 200];
                  $etiketX = $x + $w/2;
                  $etiketY = $y + $h/2;
                  $ikonBoyu = 32;
                  $ikonX = $etiketX - $ikonBoyu/2;
                  $ikonY = $etiketY - 60;
                ?>
                  <g
                    class="rez__bolge"
                    role="button"
                    tabindex="0"
                    data-bolge="<?= e($b['id']) ?>"
                    data-ad="<?= e($b['ad']) ?>"
                    data-aciklama="<?= e($b['aciklama']) ?>"
                    data-musait="<?= (int)$b['musait'] ?>"
                    aria-pressed="false"
                    aria-label="<?= e($b['ad']) ?>. <?= e($b['aciklama']) ?>. <?= (int)$b['musait'] ?> masa müsait."
                  >
                    <rect class="rez__bolge__zemin"
                      x="<?= $x ?>" y="<?= $y ?>"
                      width="<?= $w ?>" height="<?= $h ?>"
                      rx="6"
                    />
                    <svg x="<?= $ikonX ?>" y="<?= $ikonY ?>" width="<?= $ikonBoyu ?>" height="<?= $ikonBoyu ?>" viewBox="0 0 24 24" class="rez__bolge__ikon">
                      <?= bolge_ikon_yolu($b['id']) ?>
                    </svg>
                    <text class="rez__bolge__ad"
                      x="<?= $etiketX ?>" y="<?= $etiketY ?>"
                      text-anchor="middle"
                    ><?= e($b['ad']) ?></text>
                    <text class="rez__bolge__meta"
                      x="<?= $etiketX ?>" y="<?= $etiketY + 28 ?>"
                      text-anchor="middle"
                    ><?= (int)$b['musait'] > 0 ? (int)$b['musait'] . ' masa müsait' : 'DOLU' ?></text>
                  </g>
                <?php endforeach; ?>
              </svg>
            </div>

            <!-- Liste görünüm (a11y / mobil fallback) -->
            <ul class="rez__liste" hidden>
              <?php foreach ($s['bolgeler'] as $b): ?>
                <li>
                  <button
                    type="button"
                    class="rez__liste__oge"
                    data-bolge="<?= e($b['id']) ?>"
                    data-ad="<?= e($b['ad']) ?>"
                    data-aciklama="<?= e($b['aciklama']) ?>"
                    data-musait="<?= (int)$b['musait'] ?>"
                    aria-pressed="false"
                    <?= (int)$b['musait'] === 0 ? 'disabled' : '' ?>
                  >
                    <span>
                      <span class="rez__liste__ad"><?= e($b['ad']) ?></span>
                      <span class="rez__liste__meta"><?= e($b['aciklama']) ?></span>
                    </span>
                    <span class="rez__liste__meta">
                      <?= (int)$b['musait'] > 0 ? (int)$b['musait'] . ' müsait' : 'Dolu' ?>
                    </span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>

            <p class="rez__lejant" aria-hidden="true">
              <span><span class="rez__lejant__nokta rez__lejant__nokta--musait"></span>Müsait</span>
              <span><span class="rez__lejant__nokta rez__lejant__nokta--secili"></span>Seçili</span>
              <span><span class="rez__lejant__nokta rez__lejant__nokta--dolu"></span>Dolu</span>
              <span style="margin-left:auto;font-style:italic">Kroki temsili, gerçek yerleşim şubede farklılık gösterebilir.</span>
            </p>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- SAĞ: form -->
      <form
        class="rez__form"
        method="post"
        action="/rezervasyon.php#form"
        id="form"
        novalidate
      >
        <input type="hidden" name="csrf"  value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="sube"  value="<?= e($deger['sube']) ?>">
        <input type="hidden" name="bolge" value="<?= e($deger['bolge']) ?>">

        <div class="rez__secim <?= $deger['bolge'] === '' ? 'rez__secim--bos' : '' ?>">
          <span class="ustluk" style="margin:0">Seçili bölge</span>
          <p class="rez__secim__ad" data-secim-ad>
            <?= $deger['bolge'] !== '' ? e($secili_ad ?: $deger['bolge']) : '— henüz seçilmedi —' ?>
          </p>
          <p class="rez__secim__aciklama" data-secim-aciklama>
            <?= $deger['bolge'] === '' ? 'Devam etmek için soldaki krokiden bir bölge seçin.' : e($secili_acikla) ?>
          </p>
          <?php if (!empty($hatalar['bolge'])): ?>
            <p class="alan__hata" role="alert" style="margin-top:var(--bosluk-2)"><?= e($hatalar['bolge']) ?></p>
          <?php endif; ?>
        </div>

        <fieldset class="rez__form__gerisi" data-gerisi <?= $deger['bolge'] === '' ? 'disabled' : '' ?>>
          <div class="rez__ikili">
            <div class="alan">
              <label class="alan__etiket" for="tarih">Tarih</label>
              <input class="girdi" id="tarih" name="tarih" type="date"
                min="<?= date('Y-m-d') ?>"
                value="<?= e($deger['tarih']) ?>"
                autocomplete="off"
                <?= !empty($hatalar['tarih']) ? 'aria-invalid="true" aria-describedby="tarih-hata"' : '' ?>>
              <p class="alan__hata" id="tarih-hata" role="alert"><?= e($hatalar['tarih'] ?? '') ?></p>
            </div>

            <div class="alan">
              <label class="alan__etiket" for="kisi">Kişi sayısı</label>
              <div class="stepper" data-stepper>
                <button type="button" class="stepper__btn" data-stepper-azalt aria-label="Azalt">−</button>
                <span class="stepper__deger" aria-hidden="true"><?= (int)$deger['kisi'] ?></span>
                <input id="kisi" name="kisi" type="number" min="1" max="12"
                  value="<?= (int)$deger['kisi'] ?>"
                  class="gorunmez"
                  inputmode="numeric">
                <button type="button" class="stepper__btn" data-stepper-artir aria-label="Artır">+</button>
              </div>
              <p class="alan__hata" role="alert"><?= e($hatalar['kisi'] ?? '') ?></p>
            </div>
          </div>

          <fieldset class="alan rez__saat">
            <legend class="alan__etiket">Saat</legend>
            <?php foreach ($saatGruplar as $anahtar => $liste): ?>
              <div class="rez__saat__grup">
                <span class="ustluk rez__saat__baslik"><?= e($saatEtiket[$anahtar]) ?></span>
                <div class="chip-grup">
                  <?php foreach ($liste as $sa):
                    $sec = ($sa === $deger['saat']);
                  ?>
                    <label class="chip">
                      <input type="radio" name="saat" value="<?= e($sa) ?>" <?= $sec ? 'checked' : '' ?>>
                      <span><?= e($sa) ?></span>
                    </label>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>
            <p class="alan__hata" role="alert"><?= e($hatalar['saat'] ?? '') ?></p>
          </fieldset>

          <div class="alan">
            <label class="alan__etiket" for="ad">Ad Soyad</label>
            <input class="girdi" id="ad" name="ad" type="text"
              value="<?= e($deger['ad']) ?>"
              autocomplete="name"
              data-dogrula
              aria-describedby="ad-hata"
              <?= !empty($hatalar['ad']) ? 'aria-invalid="true"' : '' ?>>
            <p class="alan__hata" id="ad-hata" role="alert"><?= e($hatalar['ad'] ?? '') ?></p>
          </div>

          <div class="alan">
            <label class="alan__etiket" for="tel">Telefon</label>
            <input class="girdi" id="tel" name="tel" type="tel"
              value="<?= e($deger['tel']) ?>"
              placeholder="0 5xx xxx xx xx"
              autocomplete="tel"
              inputmode="tel"
              data-dogrula
              aria-describedby="tel-hata"
              <?= !empty($hatalar['tel']) ? 'aria-invalid="true"' : '' ?>>
            <p class="alan__hata" id="tel-hata" role="alert"><?= e($hatalar['tel'] ?? '') ?></p>
          </div>

          <div class="alan">
            <label class="alan__etiket" for="not">Not (isteğe bağlı)</label>
            <textarea class="metin-alani" id="not" name="not"
              maxlength="500"
              aria-describedby="not-yardim"><?= e($deger['not']) ?></textarea>
            <p class="alan__yardim" id="not-yardim">Alerjileriniz, özel gün, tercih ettiğiniz masa.</p>
          </div>

          <div class="alan alan--onay">
            <label class="onay">
              <input type="checkbox" name="kvkk" value="1" data-kvkk
                <?= $deger['kvkk'] ? 'checked' : '' ?>
                <?= !empty($hatalar['kvkk']) ? 'aria-invalid="true" aria-describedby="kvkk-hata"' : '' ?>>
              <span>
                <a href="/kvkk.php" target="_blank" rel="noopener" class="baglanti-vurgu">KVKK Aydınlatma Metni</a>'ni
                okudum, kişisel verilerimin rezervasyon amacıyla işlenmesine onay veriyorum.
              </span>
            </label>
            <p class="alan__hata" id="kvkk-hata" role="alert"><?= e($hatalar['kvkk'] ?? '') ?></p>
          </div>

          <button type="submit" class="btn btn--birincil btn--tam" data-submit disabled>
            Rezervasyonu onayla
          </button>
        </fieldset>
      </form>
    </div>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
