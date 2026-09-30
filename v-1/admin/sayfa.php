<?php
declare(strict_types=1);
require_once __DIR__ . '/ortak.php';
admin_zorunlu();

$ad = preg_replace('/[^a-z0-9_-]/', '', (string) ($_GET['ad'] ?? ''));
$veri = veri_oku();
if ($ad === '' || !isset($veri['sayfalar'][$ad])) {
    header('Location: /admin/');
    exit;
}

$bildirim = '';
$hata = '';

/* ---------------- POST kaydet ---------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_dogrula();

    // Önce satır içi yüklenen görselleri işle — başarılı olanların dosya adı
    // ilgili $_POST['bolum'][i][alan] alanına yazılır.
    $yuklemeMesajlari = [];
    if (!empty($_FILES['yukle']['name']) && is_array($_FILES['yukle']['name'])) {
        // Not: döngü değişkeni $ad olmamalı — sayfa slug'ı ($ad) ezilirdi.
        foreach ($_FILES['yukle']['name'] as $i => $alanlar) {
            if (!is_array($alanlar)) continue;
            foreach ($alanlar as $alan => $dosyaAdi) {
                $err = $_FILES['yukle']['error'][$i][$alan] ?? UPLOAD_ERR_NO_FILE;
                if ($err !== UPLOAD_ERR_OK) continue;
                $tmp = $_FILES['yukle']['tmp_name'][$i][$alan];

                // Dosya adı: mevcut slot'un adını kullan; yoksa gelen dosya adı
                $mevcut = (string) ($_POST['bolum'][$i][$alan] ?? '');
                $tabanAd = $mevcut !== '' ? pathinfo($mevcut, PATHINFO_FILENAME) : pathinfo($dosyaAdi, PATHINFO_FILENAME);

                $sonuc = gorsel_yukle_isle($tmp, $dosyaAdi, $tabanAd, true);
                if ($sonuc['ok']) {
                    $_POST['bolum'][$i][$alan] = $sonuc['deger'];
                    $yuklemeMesajlari[] = $sonuc['mesaj'];
                } else {
                    $hata = $sonuc['mesaj'];
                }
            }
        }
    }

    $gelen = $_POST['bolum'] ?? [];
    if (!is_array($gelen)) $gelen = [];

    $yeniBolumler = [];
    ksort($gelen, SORT_NUMERIC);
    foreach ($gelen as $idx => $b) {
        if (!is_array($b) || empty($b['tip'])) continue;

        // Skaler alanları temizle
        $temiz = [];
        foreach ($b as $anahtar => $deger) {
            if ($anahtar === '__json_alanlar') continue;
            if (is_string($deger)) {
                $temiz[$anahtar] = trim($deger);
            } elseif (is_array($deger)) {
                $temiz[$anahtar] = $deger;
            } else {
                $temiz[$anahtar] = $deger;
            }
        }

        // JSON alanları (ogeler, kategoriler vb.) çöz
        $jsonAlanlar = (string) ($b['__json_alanlar'] ?? '');
        foreach (array_filter(array_map('trim', explode(',', $jsonAlanlar))) as $jAlan) {
            $ham = (string) ($temiz[$jAlan] ?? '');
            if ($ham === '') { unset($temiz[$jAlan]); continue; }
            $parsed = json_decode($ham, true);
            if (!is_array($parsed)) {
                $hata = "Bölüm #" . ((int)$idx + 1) . " · <code>{$jAlan}</code> alanındaki JSON hatalı.";
                $yeniBolumler = null;
                break 2;
            }
            $temiz[$jAlan] = $parsed;
        }

        // Boolean alanlar
        if (isset($temiz['kirp'])) {
            $temiz['kirp'] = filter_var($temiz['kirp'], FILTER_VALIDATE_BOOLEAN);
        }

        // Sayısal alanlar
        foreach (['en', 'boy'] as $sayiAlan) {
            if (isset($temiz[$sayiAlan]) && $temiz[$sayiAlan] !== '') {
                $temiz[$sayiAlan] = (int) $temiz[$sayiAlan];
            }
        }

        // Boş metin alanları kaldırma yerine bırakılıyor (silmek kırabilir)
        unset($temiz['__json_alanlar']);
        $yeniBolumler[] = $temiz;
    }

    if ($yeniBolumler !== null) {
        $veri['sayfalar'][$ad] = $yeniBolumler;
        if (veri_yaz($veri)) {
            $bildirim = 'Değişiklikler kaydedildi.'
                . ($yuklemeMesajlari ? ' · ' . implode(' · ', $yuklemeMesajlari) : '');
        } else {
            $hata = 'Yazma başarısız (izin kontrol edin: data/ dizini yazılabilir olmalı).';
        }
    }
}

$bolumler = $veri['sayfalar'][$ad];
$gorseller = gorsel_listesi();

$baslik = sayfa_etiket($ad) . ' düzenle';
require __DIR__ . '/_ust.php';
?>

<div class="admin-baslik-seridi">
  <a href="/admin/" class="admin-geri">← Panel</a>
  <h1 class="admin-baslik"><?= e(sayfa_etiket($ad)) ?></h1>
  <a href="/<?= e($ad === 'anasayfa' ? '' : $ad . '.php') ?>" target="_blank" rel="noopener" class="admin-btn admin-btn--ikincil">Sayfayı gör ↗</a>
</div>

<?php if ($bildirim): ?><p class="admin-uyari admin-uyari--basari"><?= $bildirim ?></p><?php endif; ?>
<?php if ($hata): ?><p class="admin-uyari admin-uyari--hata"><?= $hata ?></p><?php endif; ?>

<form method="post" enctype="multipart/form-data" class="admin-form">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

  <?php foreach ($bolumler as $i => $b):
    $tip = (string) ($b['tip'] ?? '');
    // Bu bölümde JSON olarak düzenlenecek alanlar
    $jsonAlanlar = [];
    foreach (['ogeler', 'kategoriler', 'bolumler'] as $ja) {
      if (isset($b[$ja]) && is_array($b[$ja])) $jsonAlanlar[] = $ja;
    }
  ?>
    <section class="admin-bolum" data-tip="<?= e($tip) ?>">
      <div class="admin-bolum__legend">
        <span class="admin-bolum__no"><?= sprintf('%02d', $i + 1) ?></span>
        <span class="admin-bolum__tip"><?= e(bolum_tip_etiket($tip)) ?></span>
        <?php if (!empty($b['baslik'])): ?>
          <span class="admin-bolum__ipucu">— <?= e($b['baslik']) ?></span>
        <?php elseif (!empty($b['ustluk'])): ?>
          <span class="admin-bolum__ipucu">— <?= e($b['ustluk']) ?></span>
        <?php endif; ?>
      </div>

      <input type="hidden" name="bolum[<?= $i ?>][tip]" value="<?= e($tip) ?>">
      <input type="hidden" name="bolum[<?= $i ?>][__json_alanlar]" value="<?= e(implode(',', $jsonAlanlar)) ?>">

      <?php
      // Alan sıralaması — bilinen alanlar önce, sonra kalanlar
      $sira = ['ustluk', 'baslik', 'alt_baslik', 'metin', 'yon', 'zemin', 'kirp',
               'buton_yazi', 'buton_link', 'buton2_yazi', 'buton2_link',
               'gorsel', 'gorsel_mobil', 'gorsel_odak', 'gorsel_alt', 'en', 'boy',
               'duzen', 'on_secili_sube'];
      $goruntulenen = [];
      foreach ($sira as $k) {
        if (array_key_exists($k, $b) && $k !== 'tip') $goruntulenen[] = $k;
      }
      foreach ($b as $k => $_) {
        if ($k === 'tip') continue;
        if (!in_array($k, $goruntulenen, true)) $goruntulenen[] = $k;
      }
      ?>

      <?php foreach ($goruntulenen as $k):
        $v = $b[$k];
        $ad_input = "bolum[{$i}][{$k}]";
      ?>
        <?php if (in_array($k, $jsonAlanlar, true)): ?>
          <label class="admin-alan">
            <span><?= e(alan_etiket($k)) ?> <small class="admin-alan__ipucu">(JSON — dikkatli düzenleyin)</small></span>
            <textarea name="<?= e($ad_input) ?>" rows="12" class="admin-json"><?= e(json_encode($v, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?></textarea>
          </label>
        <?php elseif ($k === 'gorsel' || $k === 'gorsel_mobil'): ?>
          <div class="admin-alan admin-alan--gorsel">
            <span><?= e(alan_etiket($k)) ?>
              <?php if ($v): ?><small class="admin-alan__ipucu">şu an: <code><?= e((string)$v) ?></code></small><?php endif; ?>
            </span>
            <div class="admin-gorsel-secici" data-secici>
              <div class="admin-gorsel-secici__onizleme">
                <img src="<?= $v ? e(gorsel_url((string)$v)) : '' ?>" alt="" loading="lazy"<?= !$v ? ' hidden' : '' ?>>
                <span class="admin-gorsel-secici__bos"<?= $v ? ' hidden' : '' ?>>Görsel yok</span>
              </div>
              <div class="admin-gorsel-secici__kontrol">
                <label class="admin-gorsel-secici__satir">
                  <span>Kütüphaneden seç</span>
                  <select name="<?= e($ad_input) ?>" data-secici-secim>
                    <option value="">— Seçim yok —</option>
                    <?php foreach ($gorseller as $g): ?>
                      <option value="<?= e($g) ?>" data-url="<?= e(gorsel_url($g)) ?>" <?= $g === $v ? 'selected' : '' ?>><?= e(basename($g)) ?></option>
                    <?php endforeach; ?>
                  </select>
                </label>
                <label class="admin-gorsel-secici__satir">
                  <span>veya yeni dosya yükle</span>
                  <input type="file" name="yukle[<?= $i ?>][<?= e($k) ?>]" accept="image/*">
                </label>
                <p class="admin-gorsel-secici__not">Yükleme yaparsan slot bu görselle güncellenir; kütüphane seçimi göz ardı edilir.</p>
              </div>
            </div>
          </div>
        <?php elseif ($k === 'gorsel_odak'): ?>
          <label class="admin-alan">
            <span><?= e(alan_etiket($k)) ?></span>
            <select name="<?= e($ad_input) ?>">
              <?php foreach (['merkez'=>'Merkez','ust'=>'Üst','alt'=>'Alt','sol'=>'Sol','sag'=>'Sağ'] as $opt=>$et): ?>
                <option value="<?= e($opt) ?>" <?= $opt === $v ? 'selected' : '' ?>><?= e($et) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
        <?php elseif ($k === 'zemin'): ?>
          <label class="admin-alan">
            <span><?= e(alan_etiket($k)) ?></span>
            <select name="<?= e($ad_input) ?>">
              <?php foreach (['beyaz'=>'Beyaz','kum'=>'Kum','koyu'=>'Koyu'] as $opt=>$et): ?>
                <option value="<?= e($opt) ?>" <?= $opt === $v ? 'selected' : '' ?>><?= e($et) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
        <?php elseif ($k === 'yon'): ?>
          <label class="admin-alan">
            <span><?= e(alan_etiket($k)) ?></span>
            <select name="<?= e($ad_input) ?>">
              <option value="sag" <?= $v==='sag'?'selected':'' ?>>Sağ</option>
              <option value="sol" <?= $v==='sol'?'selected':'' ?>>Sol</option>
            </select>
          </label>
        <?php elseif ($k === 'kirp'): ?>
          <label class="admin-alan admin-alan--onay">
            <input type="hidden" name="<?= e($ad_input) ?>" value="0">
            <input type="checkbox" name="<?= e($ad_input) ?>" value="1" <?= !empty($v) ? 'checked' : '' ?>>
            <span><?= e(alan_etiket($k)) ?></span>
          </label>
        <?php elseif (is_string($v) && (mb_strlen($v) > 90 || $k === 'metin' || $k === 'alt_baslik')): ?>
          <label class="admin-alan">
            <span><?= e(alan_etiket($k)) ?></span>
            <textarea name="<?= e($ad_input) ?>" rows="<?= $k === 'metin' ? 6 : 3 ?>"><?= e((string) $v) ?></textarea>
          </label>
        <?php else: ?>
          <label class="admin-alan">
            <span><?= e(alan_etiket($k)) ?></span>
            <input type="text" name="<?= e($ad_input) ?>" value="<?= e((string) $v) ?>">
          </label>
        <?php endif; ?>
      <?php endforeach; ?>
    </section>
  <?php endforeach; ?>

  <div class="admin-form__aksiyon">
    <button type="submit" class="admin-btn admin-btn--birincil admin-btn--lg">Değişiklikleri kaydet</button>
    <a href="/admin/" class="admin-btn admin-btn--ikincil admin-btn--lg">Vazgeç</a>
  </div>
</form>

<?php require __DIR__ . '/_alt.php'; ?>
