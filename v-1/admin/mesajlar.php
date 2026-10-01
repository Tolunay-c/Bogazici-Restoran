<?php
declare(strict_types=1);
require_once __DIR__ . '/ortak.php';
admin_zorunlu();

$tur = (string) ($_GET['tur'] ?? '');
if (!in_array($tur, ['rezervasyon', 'iletisim'], true)) {
    $tur = '';
}
$donus = '/admin/mesajlar.php' . ($tur !== '' ? '?tur=' . $tur : '');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_dogrula();
    $id = (string) ($_POST['id'] ?? '');
    match ((string) ($_POST['islem'] ?? '')) {
        'okundu'   => mesaj_okundu($id, true),
        'okunmadi' => mesaj_okundu($id, false),
        'sil'      => mesaj_sil($id),
        default    => false,
    };
    header('Location: ' . $donus, true, 303);
    exit;
}

$tumu = mesajlar_oku();
$okunamadi = $tumu === null;
$tumu ??= [];

$turuAl = static fn (array $m): string => ($m['tur'] ?? 'iletisim') === 'rezervasyon' ? 'rezervasyon' : 'iletisim';
$adet = ['' => count($tumu), 'rezervasyon' => 0, 'iletisim' => 0];
foreach ($tumu as $m) {
    $adet[$turuAl($m)]++;
}
$mesajlar = $tur === '' ? $tumu : array_values(array_filter($tumu, static fn (array $m): bool => $turuAl($m) === $tur));
$okunmamis = count(array_filter($tumu, static fn (array $m): bool => empty($m['okundu'])));

$baslik = 'Mesajlar';
require __DIR__ . '/_ust.php';
?>

<section class="admin-blok">
  <h1 class="admin-baslik">Mesajlar</h1>
  <?php if ($okunamadi): ?>
    <p class="admin-uyari admin-uyari--hata">Mesajlar şu an okunamadı. Sayfayı yenileyin; sorun sürerse daha sonra tekrar deneyin.</p>
  <?php else: ?>
  <p class="admin-yardim"><?= count($tumu) ?> mesaj · <?= $okunmamis ?> okunmamış</p>

  <nav class="admin-filtre" aria-label="Mesaj türü">
    <?php foreach (['' => 'Tümü', 'rezervasyon' => 'Rezervasyon', 'iletisim' => 'İletişim'] as $k => $etiket): ?>
      <a href="/admin/mesajlar.php<?= $k !== '' ? '?tur=' . $k : '' ?>" class="admin-filtre__link<?= $tur === $k ? ' admin-filtre__link--aktif' : '' ?>"<?= $tur === $k ? ' aria-current="page"' : '' ?>><?= e($etiket) ?> (<?= $adet[$k] ?>)</a>
    <?php endforeach; ?>
  </nav>

  <?php if (!$mesajlar): ?>
    <p class="admin-yardim">Henüz mesaj yok.</p>
  <?php else: ?>
    <div class="admin-mesaj-liste">
      <?php foreach ($mesajlar as $m):
        $yeni = empty($m['okundu']);
        $id = (string) ($m['id'] ?? '');
        $rez = $turuAl($m) === 'rezervasyon';
        $rezTarih = $rez ? DateTimeImmutable::createFromFormat('!Y-m-d', (string) ($m['rez_tarih'] ?? '')) : false;
      ?>
        <article class="admin-kart admin-mesaj<?= $yeni ? ' admin-mesaj--yeni' : '' ?>">
          <header class="admin-mesaj__ust">
            <h3 class="admin-kart__baslik"><?= e((string) ($m['ad'] ?? '')) ?> <span class="admin-etiket admin-etiket--tur"><?= $rez ? 'Rezervasyon' : 'İletişim' ?></span><?php if ($yeni): ?> <span class="admin-etiket">Yeni</span><?php endif; ?></h3>
            <span class="admin-kart__meta"><?= e((string) ($m['tarih'] ?? '')) ?></span>
          </header>
          <?php if ($rez): ?>
            <p class="admin-mesaj__rez">
              <?= e((string) ($m['sube_ad'] ?? '')) ?> ·
              <?= e($rezTarih ? $rezTarih->format('d.m.Y') : (string) ($m['rez_tarih'] ?? '')) ?> <?= e((string) ($m['saat'] ?? '')) ?> ·
              <?= (int) ($m['kisi'] ?? 0) ?> kişi
            </p>
            <p class="admin-kart__meta">
              <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', (string) ($m['telefon'] ?? ''))) ?>"><?= e((string) ($m['telefon'] ?? '')) ?></a>
            </p>
            <?php if (($m['not'] ?? '') !== ''): ?>
              <p class="admin-mesaj__metin"><?= nl2br(e((string) $m['not'])) ?></p>
            <?php endif; ?>
          <?php else: ?>
            <p class="admin-kart__meta">
              <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', (string) ($m['telefon'] ?? ''))) ?>"><?= e((string) ($m['telefon'] ?? '')) ?></a>
              ·
              <a href="mailto:<?= e((string) ($m['eposta'] ?? '')) ?>"><?= e((string) ($m['eposta'] ?? '')) ?></a>
            </p>
            <p class="admin-mesaj__metin"><?= nl2br(e((string) ($m['mesaj'] ?? ''))) ?></p>
          <?php endif; ?>
          <?php if (isset($m['mail'])): $mailDurum = (string) $m['mail']; ?>
            <p class="admin-mesaj__mail admin-mesaj__mail--<?= e($mailDurum) ?>">Mail: <?= e(MAIL_DURUM_ETIKETI[$mailDurum] ?? $mailDurum) ?></p>
          <?php endif; ?>
          <div class="admin-mesaj__aksiyon">
            <form method="post" action="<?= e($donus) ?>">
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="id" value="<?= e($id) ?>">
              <input type="hidden" name="islem" value="<?= $yeni ? 'okundu' : 'okunmadi' ?>">
              <button type="submit" class="admin-mesaj__dugme"><?= $yeni ? 'Okundu işaretle' : 'Okunmadı işaretle' ?></button>
            </form>
            <form method="post" action="<?= e($donus) ?>">
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="id" value="<?= e($id) ?>">
              <input type="hidden" name="islem" value="sil">
              <button type="submit" class="admin-mesaj__dugme admin-mesaj__dugme--sil" onclick="return confirm('Mesaj silinsin mi?')">Sil</button>
            </form>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php endif; ?>
</section>

<?php $mailLog = mail_log_son(50); ?>
<section class="admin-blok">
  <details class="admin-log">
    <summary class="admin-ustluk">Mail kayıtları (son <?= count($mailLog) ?>)</summary>
    <p class="admin-yardim">Her form gönderiminde mailin sunucuya teslim edilip edilmediği burada tutulur (data/mail.log). "Sunucuya teslim edildi" mailin gönderim kuyruğuna girdiğini gösterir; gelen kutusuna ulaşmadıysa spam klasörünü ve alan adının SPF/DKIM ayarını kontrol edin.</p>
    <?php if ($mailLog): ?>
      <pre class="admin-log__icerik"><?= e(implode("\n", $mailLog)) ?></pre>
    <?php else: ?>
      <p class="admin-yardim">Henüz kayıt yok.</p>
    <?php endif; ?>
  </details>
</section>

<?php require __DIR__ . '/_alt.php'; ?>
