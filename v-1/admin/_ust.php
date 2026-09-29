<?php /** @var string $baslik */ ?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($baslik ?? 'Yönetim') ?> · Boğaziçi</title>
<link rel="stylesheet" href="/admin/stil.css">
</head>
<body class="admin">

<header class="admin-ust">
  <a href="/admin/" class="admin-ust__logo">Boğaziçi <span>· Yönetim</span></a>
  <nav class="admin-ust__nav">
    <a href="/admin/">Panel</a>
    <a href="/admin/gorsel.php">Görseller</a>
    <a href="/" target="_blank" rel="noopener">Siteyi Aç ↗</a>
    <a href="/admin/cikis.php" class="admin-ust__cikis">Çıkış</a>
  </nav>
</header>

<main class="admin-icerik">
