<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// /v-1 veya /v-1/... — eski sürüme arşiv erişimi
if ($uri === 'v-1' || str_starts_with($uri, 'v-1/')) {
    $subPath = preg_replace('#^v-1/?#', '', $uri);
    $baseDir = realpath(__DIR__ . '/../v-1');
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

// /v-2 veya /v-2/... — açık istekle v-2'ye erişim (rewrite yapılmadan çağrılıyorsa)
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

// Varsayılan — kök URL'ler v-1 yayınına düşer (canlı sürüm)
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
