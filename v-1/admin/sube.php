<?php
declare(strict_types=1);
require_once __DIR__ . '/ortak.php';
admin_zorunlu();

$veri = veri_oku();
$slug = preg_replace('/[^a-z0-9-]/', '', (string) ($_GET['slug'] ?? ''));
$yeni = !empty($_GET['yeni']);

$mevcut = null; $index = null;
if ($slug !== '') {
    foreach ($veri['subeler'] as $i => $s) {
        if (($s['slug'] ?? '') === $slug) { $mevcut = $s; $index = $i; break; }
    }
}

if (!$mevcut && !$yeni) {
    header('Location: /admin/');
    exit;
}

$bildirim = ''; $hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_dogrula();
    $eylem = (string) ($_POST['eylem'] ?? 'kaydet');

    // Görsel satır içi yükleme
    if (!empty($_FILES['yukle_gorsel']['name']) && ($_FILES['yukle_gorsel']['error'] ?? 0) === UPLOAD_ERR_OK) {
        $f = $_FILES['yukle_gorsel'];
        $mevcut = (string) ($_POST['sube']['gorsel'] ?? '');
        $slugAdı = trim((string) ($_POST['sube']['slug'] ?? ''));
        $tabanAd = $mevcut !== '' ? pathinfo($mevcut, PATHINFO_FILENAME)
            : ($slugAdı !== '' ? 'sube-' . $slugAdı : pathinfo($f['name'], PATHINFO_FILENAME));
        $sonuc = gorsel_yukle_isle($f['tmp_name'], $f['name'], $tabanAd, true);
        if ($sonuc['ok']) {
            $_POST['sube']['gorsel'] = $sonuc['deger'];
            $bildirim = 'Görsel ' . lcfirst($sonuc['mesaj']);
        } else {
            $hata = $sonuc['mesaj'];
        }
    }

    // Şube sayfası banner görseli
    if (!empty($_FILES['yukle_banner']['name']) && ($_FILES['yukle_banner']['error'] ?? 0) === UPLOAD_ERR_OK) {
        $f = $_FILES['yukle_banner'];
        $mevcutBanner = (string) ($_POST['sube']['banner'] ?? '');
        $slugAdı = trim((string) ($_POST['sube']['slug'] ?? ''));
        $tabanAd = $mevcutBanner !== '' ? pathinfo($mevcutBanner, PATHINFO_FILENAME)
            : ($slugAdı !== '' ? 'sube-banner-' . $slugAdı : pathinfo($f['name'], PATHINFO_FILENAME));
        $sonuc = gorsel_yukle_isle($f['tmp_name'], $f['name'], $tabanAd, true);
        if ($sonuc['ok']) {
            $_POST['sube']['banner'] = $sonuc['deger'];
            $bildirim = 'Banner ' . lcfirst($sonuc['mesaj']);
        } else {
            $hata = $sonuc['mesaj'];
        }
    }

    if ($eylem === 'sil' && $index !== null) {
        array_splice($veri['subeler'], $index, 1);
        if (veri_yaz($veri)) {
            header('Location: /admin/');
            exit;
        }
        $hata = 'Silme başarısız.';
    } else {
        $g = $_POST['sube'] ?? [];
        $bolgeler = array_values(array_filter(array_map('trim', explode("\n", (string) ($g['bolgeler_ham'] ?? '')))));

        $yeniSube = [
            'slug'         => preg_replace('/[^a-z0-9-]/', '', mb_strtolower(trim((string) ($g['slug'] ?? '')))),
            'ad'           => trim((string) ($g['ad'] ?? '')),
            'adres'        => trim((string) ($g['adres'] ?? '')),
            'telefon'      => trim((string) ($g['telefon'] ?? '')),
            'telefon_yazi' => trim((string) ($g['telefon_yazi'] ?? '')),
            'telefon2_yazi' => trim((string) ($g['telefon2_yazi'] ?? '')),
            'eposta'       => trim((string) ($g['eposta'] ?? '')),
            'saat'         => trim((string) ($g['saat'] ?? '')),
            'gorsel'       => trim((string) ($g['gorsel'] ?? '')),
            'banner'       => trim((string) ($g['banner'] ?? '')),
            'enlem'        => (float) ($g['enlem'] ?? 0),
            'boylam'       => (float) ($g['boylam'] ?? 0),
            'yol_tarifi'   => trim((string) ($g['yol_tarifi'] ?? '')),
            'bolgeler'     => $bolgeler,
            'paket_servis' => trim((string) ($g['paket_servis'] ?? '')),
            'not'          => implode("\n", array_filter(array_map('trim', preg_split('/\R/u', (string) ($g['not'] ?? '')) ?: []), 'strlen')),
        ];

        if ($yeniSube['slug'] === '' || $yeniSube['ad'] === '') {
            $hata = 'Slug ve şube adı zorunlu.';
        } else {
            if ($index === null) {
                // Yeni ekleme — slug çakışıyor mu?
                foreach ($veri['subeler'] as $s) {
                    if ($s['slug'] === $yeniSube['slug']) {
                        $hata = 'Bu slug zaten kullanılıyor.';
                        break;
                    }
                }
                if (!$hata) {
                    $veri['subeler'][] = $yeniSube;
                }
            } else {
                $veri['subeler'][$index] = $yeniSube;
            }

            if (!$hata) {
                if (veri_yaz($veri)) {
                    header('Location: /admin/sube.php?slug=' . urlencode($yeniSube['slug']) . '&kaydedildi=1');
                    exit;
                }
                $hata = 'Yazma başarısız.';
            }
        }
        $mevcut = $yeniSube; // POST verisini forma geri bas
    }
}

if (!empty($_GET['kaydedildi'])) {
    $bildirim = 'Şube kaydedildi.';
}

$sube = $mevcut ?? [
    'slug' => '', 'ad' => '', 'adres' => '', 'telefon' => '+90', 'telefon_yazi' => '',
    'eposta' => '', 'saat' => 'Her gün 12:00 – 24:00', 'gorsel' => '', 'banner' => '',
    'enlem' => 38.4, 'boylam' => 27.1, 'yol_tarifi' => '', 'bolgeler' => [],
    'paket_servis' => '', 'not' => '',
];

$gorseller = gorsel_listesi();
$baslik = $yeni ? 'Yeni şube' : ('Şube · ' . $sube['ad']);
require __DIR__ . '/_ust.php';
?>

<div class="admin-baslik-seridi">
  <a href="/admin/" class="admin-geri">← Panel</a>
  <h1 class="admin-baslik"><?= e($baslik) ?></h1>
  <?php if (!$yeni && $index !== null): ?>
    <form method="post" onsubmit="return confirm('Bu şubeyi silmek istediğinize emin misiniz?')" style="margin:0">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="hidden" name="eylem" value="sil">
      <button class="admin-btn admin-btn--tehlike" type="submit">Şubeyi sil</button>
    </form>
  <?php endif; ?>
</div>

<?php if ($bildirim): ?><p class="admin-uyari admin-uyari--basari"><?= e($bildirim) ?></p><?php endif; ?>
<?php if ($hata): ?><p class="admin-uyari admin-uyari--hata"><?= e($hata) ?></p><?php endif; ?>

<form method="post" enctype="multipart/form-data" class="admin-form">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

  <section class="admin-bolum">
    <div class="admin-bolum__legend"><span class="admin-bolum__tip">Kimlik</span></div>

    <label class="admin-alan">
      <span>Slug <small class="admin-alan__ipucu">(URL için — yalnız küçük harf, tire)</small></span>
      <input type="text" name="sube[slug]" value="<?= e($sube['slug']) ?>" required pattern="[a-z0-9-]+">
    </label>

    <label class="admin-alan">
      <span>Ad</span>
      <input type="text" name="sube[ad]" value="<?= e($sube['ad']) ?>" required>
    </label>

    <label class="admin-alan">
      <span>Adres</span>
      <textarea name="sube[adres]" rows="2"><?= e($sube['adres']) ?></textarea>
    </label>

    <label class="admin-alan">
      <span>Çalışma saati</span>
      <input type="text" name="sube[saat]" value="<?= e($sube['saat']) ?>">
    </label>
  </section>

  <section class="admin-bolum">
    <div class="admin-bolum__legend"><span class="admin-bolum__tip">İletişim</span></div>

    <label class="admin-alan">
      <span>Telefon (tel: link)</span>
      <input type="text" name="sube[telefon]" value="<?= e($sube['telefon']) ?>" placeholder="+908508500850">
    </label>

    <label class="admin-alan">
      <span>Telefon (gösterim)</span>
      <input type="text" name="sube[telefon_yazi]" value="<?= e($sube['telefon_yazi']) ?>" placeholder="0850 850 0850">
    </label>

    <label class="admin-alan">
      <span>İkinci telefon <small class="admin-alan__ipucu">(opsiyonel — kartlarda ilk numaranın altında görünür; boş bırakılırsa görünmez)</small></span>
      <input type="text" name="sube[telefon2_yazi]" value="<?= e($sube['telefon2_yazi'] ?? SUBE_IKINCI_TELEFON) ?>" placeholder="0850 850 0850">
    </label>

    <label class="admin-alan">
      <span>E-posta</span>
      <input type="email" name="sube[eposta]" value="<?= e($sube['eposta']) ?>">
    </label>

    <label class="admin-alan">
      <span>Yol tarifi bağlantısı (Google Maps)</span>
      <input type="url" name="sube[yol_tarifi]" value="<?= e($sube['yol_tarifi']) ?>">
    </label>

    <label class="admin-alan">
      <span>Paket servis bağlantısı <small class="admin-alan__ipucu">(opsiyonel — boş bırakılırsa kart üzerinde buton görünmez)</small></span>
      <input type="text" name="sube[paket_servis]" value="<?= e($sube['paket_servis'] ?? '') ?>" placeholder="/hizmetler.php#paket-servis">
    </label>

    <label class="admin-alan">
      <span>Kart notları <small class="admin-alan__ipucu">(opsiyonel — her satıra bir not; telefonun altında alt alta görünür, ör. "Kahvaltı Servisi Mevcuttur" / "Paket Servis Mevcuttur"; boş bırakılırsa görünmez)</small></span>
      <textarea name="sube[not]" rows="3" maxlength="400"><?= e($sube['not'] ?? '') ?></textarea>
    </label>
  </section>

  <section class="admin-bolum">
    <div class="admin-bolum__legend"><span class="admin-bolum__tip">Konum</span></div>

    <div class="admin-cift">
      <label class="admin-alan">
        <span>Enlem</span>
        <input type="text" name="sube[enlem]" value="<?= e((string) $sube['enlem']) ?>">
      </label>
      <label class="admin-alan">
        <span>Boylam</span>
        <input type="text" name="sube[boylam]" value="<?= e((string) $sube['boylam']) ?>">
      </label>
    </div>
  </section>

  <section class="admin-bolum">
    <div class="admin-bolum__legend"><span class="admin-bolum__tip">Görsel</span></div>

    <div class="admin-alan admin-alan--gorsel">
      <span>Şube kart görseli <small class="admin-alan__ipucu">(şube kartları ve şube sayfasındaki Mekân bölümü)</small></span>
      <div class="admin-gorsel-secici" data-secici>
        <div class="admin-gorsel-secici__onizleme">
          <img src="<?= !empty($sube['gorsel']) ? e(gorsel_url((string) $sube['gorsel'])) : '' ?>" alt="" loading="lazy"<?= empty($sube['gorsel']) ? ' hidden' : '' ?>>
          <span class="admin-gorsel-secici__bos"<?= !empty($sube['gorsel']) ? ' hidden' : '' ?>>Görsel yok</span>
        </div>
        <div class="admin-gorsel-secici__kontrol">
          <label class="admin-gorsel-secici__satir">
            <span>Kütüphaneden seç</span>
            <select name="sube[gorsel]" data-secici-secim>
              <option value="">— Seçim yok —</option>
              <?php foreach ($gorseller as $g): ?>
                <option value="<?= e($g) ?>" data-url="<?= e(gorsel_url($g)) ?>" <?= $g === ($sube['gorsel'] ?? '') ? 'selected' : '' ?>><?= e(basename($g)) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label class="admin-gorsel-secici__satir">
            <span>veya yeni dosya yükle</span>
            <input type="file" name="yukle_gorsel" accept="image/*">
          </label>
          <p class="admin-gorsel-secici__not">Yükleme yaparsan mevcut dosyanın adıyla üzerine yazılır; kütüphane seçimi göz ardı edilir.</p>
        </div>
      </div>
    </div>
  
    <div class="admin-alan admin-alan--gorsel">
      <span>Şube sayfası banner görseli <small class="admin-alan__ipucu">(şube sayfasının en üstündeki koyu alan; önerilen 2400×800 px, konu ortada — kenarlar ekran genişliğine göre kırpılır)</small></span>
      <div class="admin-gorsel-secici" data-secici>
        <div class="admin-gorsel-secici__onizleme">
          <img src="<?= !empty($sube['banner']) ? e(gorsel_url((string) $sube['banner'])) : '' ?>" alt="" loading="lazy"<?= empty($sube['banner']) ? ' hidden' : '' ?>>
          <span class="admin-gorsel-secici__bos"<?= !empty($sube['banner']) ? ' hidden' : '' ?>>Görsel yok</span>
        </div>
        <div class="admin-gorsel-secici__kontrol">
          <label class="admin-gorsel-secici__satir">
            <span>Kütüphaneden seç</span>
            <select name="sube[banner]" data-secici-secim>
              <option value="">— Seçim yok —</option>
              <?php foreach ($gorseller as $g): ?>
                <option value="<?= e($g) ?>" data-url="<?= e(gorsel_url($g)) ?>" <?= $g === ($sube['banner'] ?? '') ? 'selected' : '' ?>><?= e(basename($g)) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <label class="admin-gorsel-secici__satir">
            <span>veya yeni dosya yükle</span>
            <input type="file" name="yukle_banner" accept="image/*">
          </label>
          <p class="admin-gorsel-secici__not">Yükleme yaparsan mevcut dosyanın adıyla üzerine yazılır; kütüphane seçimi göz ardı edilir.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="admin-bolum">
    <div class="admin-bolum__legend"><span class="admin-bolum__tip">Bölgeler</span></div>
    <label class="admin-alan">
      <span>Bölge etiketleri <small class="admin-alan__ipucu">(her satıra bir bölge)</small></span>
      <textarea name="sube[bolgeler_ham]" rows="5"><?= e(implode("\n", $sube['bolgeler'] ?? [])) ?></textarea>
    </label>
  </section>

  <div class="admin-form__aksiyon">
    <button type="submit" class="admin-btn admin-btn--birincil admin-btn--lg">Kaydet</button>
    <a href="/admin/" class="admin-btn admin-btn--ikincil admin-btn--lg">Vazgeç</a>
  </div>
</form>

<?php require __DIR__ . '/_alt.php'; ?>
