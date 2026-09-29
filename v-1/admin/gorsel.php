<?php
declare(strict_types=1);
require_once __DIR__ . '/ortak.php';
admin_zorunlu();

$bildirim = ''; $hata = '';

$izinliUzantilar = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
$maxBoyut = 8 * 1024 * 1024; // 8 MB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_dogrula();
    $eylem = (string) ($_POST['eylem'] ?? '');

    if ($eylem === 'turev-yenile') {
        $ad = basename((string) ($_POST['dosya'] ?? ''));
        $yol = gorsel_dizin() . '/' . $ad;
        if ($ad !== '' && is_file($yol)) {
            gorsel_turevlerini_uret($yol);
            $bildirim = "Türevler yenilendi: {$ad}";
        } else {
            $hata = 'Görsel bulunamadı.';
        }
    } elseif ($eylem === 'sil') {
        $ad = basename((string) ($_POST['dosya'] ?? ''));
        $yol = gorsel_dizin() . '/' . $ad;
        if ($ad !== '' && is_file($yol)) {
            if (@unlink($yol)) {
                // Responsive türevleri (-480/-960/-1440/-2200) de sil
                $uz = pathinfo($yol, PATHINFO_EXTENSION);
                $tab = pathinfo($yol, PATHINFO_FILENAME);
                foreach ([480, 960, 1440, 2200] as $g) {
                    $tur = gorsel_dizin() . '/' . $tab . '-' . $g . '.' . $uz;
                    if (is_file($tur)) @unlink($tur);
                }
                $bildirim = "Silindi: {$ad}";
            } else {
                $hata = 'Silme başarısız (izin kontrol edin).';
            }
        }
    } elseif ($eylem === 'yukle') {
        if (empty($_FILES['dosya']) || $_FILES['dosya']['error'] !== UPLOAD_ERR_OK) {
            $hata = 'Dosya yüklenemedi.';
        } else {
            $f = $_FILES['dosya'];
            if ($f['size'] > $maxBoyut) {
                $hata = 'Dosya çok büyük (max 8 MB).';
            } else {
                $uzanti = strtolower((string) pathinfo($f['name'], PATHINFO_EXTENSION));
                if (!in_array($uzanti, $izinliUzantilar, true)) {
                    $hata = 'Desteklenmeyen format. İzinli: ' . implode(', ', $izinliUzantilar);
                } else {
                    $mimeOk = true;
                    if (function_exists('mime_content_type')) {
                        $mime = mime_content_type($f['tmp_name']) ?: '';
                        $mimeOk = str_starts_with($mime, 'image/');
                    }
                    if (!$mimeOk) {
                        $hata = 'Dosya geçerli bir görsel değil.';
                    } else {
                        $hedefSlot = (string) ($_POST['hedef'] ?? '');
                        $veri = veri_oku();
                        $slotlar = gorsel_slotlari($veri);

                        // Dosya adını belirle
                        $temizAd = trim((string) ($_POST['ad'] ?? ''));
                        if ($temizAd === '' && $hedefSlot !== '' && isset($slotlar[$hedefSlot])) {
                            // hedef slot'un mevcut görselinin adını (varsa) taban al
                            $mevcut = _slot_mevcut_dosya($veri, $hedefSlot);
                            if ($mevcut !== '') {
                                $temizAd = pathinfo($mevcut, PATHINFO_FILENAME);
                            }
                        }
                        if ($temizAd === '') $temizAd = pathinfo($f['name'], PATHINFO_FILENAME);

                        $slug = preg_replace('/[^a-z0-9-]+/', '-', mb_strtolower($temizAd));
                        $slug = trim($slug, '-');
                        if ($slug === '') $slug = 'gorsel-' . date('Ymd-His');

                        $hedef = gorsel_dizin() . '/' . $slug . '.' . $uzanti;
                        // Aynı isim varsa: hedef slot'a atanacaksa üzerine yaz, değilse zaman damgası ekle
                        $onceSil = false;
                        if (is_file($hedef)) {
                            if ($hedefSlot !== '') {
                                $onceSil = true; // slot'a yerleşecek — mevcut aynı adlı dosyayı değiştir
                            } else {
                                $hedef = gorsel_dizin() . '/' . $slug . '-' . date('YmdHis') . '.' . $uzanti;
                            }
                        }

                        if ($onceSil) { @unlink($hedef); }
                        if (move_uploaded_file($f['tmp_name'], $hedef)) {
                            gorsel_turevlerini_uret($hedef);   // -480/-960/-1440/-2200 türevleri
                            $dosyaAdi = basename($hedef);
                            $msg = 'Yüklendi: ' . $dosyaAdi;
                            if ($hedefSlot !== '' && isset($slotlar[$hedefSlot])) {
                                if (slot_atama_yap($hedefSlot, $dosyaAdi)) {
                                    $msg .= ' — atandı: ' . $slotlar[$hedefSlot];
                                } else {
                                    $msg .= ' (slot atama başarısız — kütüphaneye eklendi)';
                                }
                            }
                            $bildirim = $msg;
                        } else {
                            $hata = 'Diske yazma başarısız (assets/img yazılabilir mi?).';
                        }
                    }
                }
            }
        }
    }
}

function _slot_mevcut_dosya(array $veri, string $anahtar): string
{
    $p = explode('|', $anahtar);
    if ($p[0] === 'sayfa') {
        $ad = $p[1]; $idx = (int) $p[2];
        if (!isset($veri['sayfalar'][$ad][$idx])) return '';
        if (count($p) === 4) return (string) ($veri['sayfalar'][$ad][$idx][$p[3]] ?? '');
        if (count($p) === 6 && $p[3] === 'ogeler') {
            $oi = (int) $p[4];
            return (string) ($veri['sayfalar'][$ad][$idx]['ogeler'][$oi]['gorsel'] ?? '');
        }
    } elseif ($p[0] === 'sube') {
        foreach ($veri['subeler'] as $s) {
            if (($s['slug'] ?? '') === $p[1]) return (string) ($s['gorsel'] ?? '');
        }
    }
    return '';
}

$veri = veri_oku();
$kullanim = gorsel_kullanimlari($veri);
$slotlar  = gorsel_slotlari($veri);
$gorseller = gorsel_listesi();

$baslik = 'Görseller';
require __DIR__ . '/_ust.php';
?>

<div class="admin-baslik-seridi">
  <a href="/admin/" class="admin-geri">← Panel</a>
  <h1 class="admin-baslik">Görseller <small><?= count($gorseller) ?></small></h1>
</div>

<?php if ($bildirim): ?><p class="admin-uyari admin-uyari--basari"><?= e($bildirim) ?></p><?php endif; ?>
<?php if ($hata): ?><p class="admin-uyari admin-uyari--hata"><?= e($hata) ?></p><?php endif; ?>

<section class="admin-blok">
  <h2 class="admin-ustluk">Yeni görsel yükle</h2>
  <form method="post" enctype="multipart/form-data" class="admin-form">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="eylem" value="yukle">

    <div class="admin-form__satir">
      <label class="admin-alan">
        <span>Görsel dosyası</span>
        <input type="file" name="dosya" accept="image/*" required>
      </label>

      <label class="admin-alan">
        <span>Hedef slot <small class="admin-alan__ipucu">(bu görsel neyin yerine koyulacak?)</small></span>
        <select name="hedef">
          <option value="">— Yalnız kütüphaneye ekle —</option>
          <?php
          // Slotları sayfa/şube gruplandır
          $grup = [];
          foreach ($slotlar as $k => $v) {
              $onek = str_starts_with($k, 'sube|') ? 'Şubeler' : sayfa_etiket(explode('|', $k)[1]);
              $grup[$onek][$k] = $v;
          }
          foreach ($grup as $g => $items): ?>
            <optgroup label="<?= e($g) ?>">
              <?php foreach ($items as $k => $etk): ?>
                <option value="<?= e($k) ?>"><?= e($etk) ?></option>
              <?php endforeach; ?>
            </optgroup>
          <?php endforeach; ?>
        </select>
      </label>

      <label class="admin-alan">
        <span>Dosya adı <small class="admin-alan__ipucu">(boş bırakırsan hedef slot'un adını alır)</small></span>
        <input type="text" name="ad" placeholder="ör: hero-anasayfa">
      </label>
    </div>

    <div class="admin-form__aksiyon" style="margin-top:12px; padding-top:0; border:0;">
      <button type="submit" class="admin-btn admin-btn--birincil">Yükle</button>
      <span class="admin-yardim" style="margin:0;">
        Desteklenen: JPG, PNG, WebP, GIF · Max 8 MB · Görseller <code>object-fit: cover</code> ile slot'a yerleşir.
      </span>
    </div>
  </form>
</section>

<section class="admin-blok">
  <h2 class="admin-ustluk">Kütüphane</h2>
  <?php if (!$gorseller): ?>
    <p class="admin-yardim">Henüz görsel yok.</p>
  <?php else: ?>
    <div class="admin-gorsel-izgara">
      <?php foreach ($gorseller as $g):
        $kul = $kullanim[$g] ?? [];
      ?>
        <figure class="admin-gorsel-oge <?= empty($kul) ? 'admin-gorsel-oge--bos' : '' ?>">
          <img src="/assets/img/<?= e($g) ?>" alt="<?= e($g) ?>" loading="lazy">
          <figcaption>
            <div class="admin-gorsel-oge__ust">
              <code title="<?= e($g) ?>"><?= e($g) ?></code>
              <div class="admin-gorsel-oge__aksiyonlar">
                <form method="post" title="480/960/1440/2200 türevlerini yeniden üret">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="eylem" value="turev-yenile">
                  <input type="hidden" name="dosya" value="<?= e($g) ?>">
                  <button type="submit" class="admin-btn admin-btn--ikincil admin-btn--sm">Türevler</button>
                </form>
                <form method="post" onsubmit="return confirm('<?= e($g) ?> silinsin mi?')">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="eylem" value="sil">
                  <input type="hidden" name="dosya" value="<?= e($g) ?>">
                  <button type="submit" class="admin-btn admin-btn--tehlike admin-btn--sm">Sil</button>
                </form>
              </div>
            </div>
            <div class="admin-gorsel-oge__kullanim">
              <?php if ($kul): ?>
                <?php foreach ($kul as $k): ?>
                  <a class="admin-rozet" href="<?= e($k['link']) ?>" title="<?= e($k['yer']) ?>"><?= e($k['yer']) ?></a>
                <?php endforeach; ?>
              <?php else: ?>
                <span class="admin-rozet admin-rozet--bos">Kullanılmıyor</span>
              <?php endif; ?>
            </div>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/_alt.php'; ?>
