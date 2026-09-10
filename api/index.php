<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// İstek /v-2 ile mi başlıyor?
if ($uri === 'v-2' || str_starts_with($uri, 'v-2/')) {
    $subPath = preg_replace('#^v-2/?#', '', $uri);
    $baseDir = realpath(__DIR__ . '/../v-2');
    chdir($baseDir);

    if ($subPath === '' || $subPath === 'index.php') {
        require $baseDir . '/index.php';
        exit;
    }

    $target = realpath($baseDir . '/' . $subPath);
    if ($target && str_starts_with($target, $baseDir) && file_exists($target) && !is_dir($target)) {
        require $target;
    } else {
        require $baseDir . '/index.php';
    }
    exit;
}

// Geri kalan tüm istekler v-1 için çalışır
$baseDir = realpath(__DIR__ . '/../v-1');
chdir($baseDir);

if ($uri === '' || $uri === 'index.php') {
    require $baseDir . '/index.php';
    exit;
}

$target = realpath($baseDir . '/' . $uri);
if ($target && str_starts_with($target, $baseDir) && file_exists($target) && !is_dir($target)) {
    require $target;
} else {
    require $baseDir . '/index.php';
}