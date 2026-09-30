<?php
declare(strict_types=1);
require_once __DIR__ . '/ortak.php';

$hata = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_dogrula();
    $k = trim((string) ($_POST['kullanici'] ?? ''));
    $p = (string) ($_POST['parola'] ?? '');
    $ayar = admin_ayar();

    if ($k === $ayar['kullanici'] && password_verify($p, $ayar['parola_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_kullanici'] = $k;
        header('Location: /admin/');
        exit;
    }
    $hata = 'Kullanıcı adı veya parola hatalı.';
}

if (admin_giris_yapmis()) {
    header('Location: /admin/');
    exit;
}
?><!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin girişi · Boğaziçi</title>
<link rel="stylesheet" href="/admin/stil.css">
</head>
<body class="admin admin--giris">
  <main class="admin-giris">
    <div class="admin-giris__kart">
      <p class="admin-giris__ustluk">Boğaziçi · Yönetim</p>
      <h1 class="admin-giris__baslik">Giriş yapın</h1>

      <?php if (DEMO_MODU): ?>
        <p class="admin-uyari admin-uyari--demo">Bu panel önizleme amaçlıdır; yaptığınız değişiklikler kaydedilmez. Canlı sunucuda tüm özellikler aktif olacaktır.</p>
      <?php endif; ?>

      <?php if ($hata): ?>
        <p class="admin-uyari admin-uyari--hata"><?= e($hata) ?></p>
      <?php endif; ?>

      <form method="post" class="admin-form">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

        <label class="admin-alan">
          <span>Kullanıcı</span>
          <input type="text" name="kullanici" autocomplete="username" required autofocus>
        </label>

        <label class="admin-alan">
          <span>Parola</span>
          <input type="password" name="parola" autocomplete="current-password" required>
        </label>

        <button type="submit" class="admin-btn admin-btn--birincil">Giriş</button>
      </form>
    </div>
  </main>
</body>
</html>
