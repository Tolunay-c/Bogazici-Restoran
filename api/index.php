<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

/**
 * Verilen taban dizin altında $subPath'ı çözümler.
 *  - Boş yol veya index.php     -> {baseDir}/index.php
 *  - Bir dosyaya işaret ediyor  -> o dosya
 *  - Bir dizine işaret ediyor   -> {dizin}/index.php varsa o
 *  - Aksi halde                  -> {baseDir}/index.php (SPA-fallback)
 */
function calistir(string $baseDir, string $subPath): void
{
    chdir($baseDir);

    if ($subPath === '' || $subPath === 'index.php') {
        require $baseDir . '/index.php';
        return;
    }

    $target = realpath($baseDir . '/' . $subPath);
    if ($target && str_starts_with($target, $baseDir)) {
        if (is_dir($target) && is_file($target . '/index.php')) {
            require $target . '/index.php';
            return;
        }
        if (is_file($target)) {
            require $target;
            return;
        }
    }
    require $baseDir . '/index.php';
}

// /v-1 veya /v-1/... — eski sürüme arşiv erişimi
if ($uri === 'v-1' || str_starts_with($uri, 'v-1/')) {
    $subPath = preg_replace('#^v-1/?#', '', $uri);
    calistir(realpath(__DIR__ . '/../v-1'), $subPath);
    exit;
}

// /v-2 veya /v-2/... — açık istekle v-2'ye erişim
if ($uri === 'v-2' || str_starts_with($uri, 'v-2/')) {
    $subPath = preg_replace('#^v-2/?#', '', $uri);
    calistir(realpath(__DIR__ . '/../v-2'), $subPath);
    exit;
}

// Varsayılan — kök URL'ler v-1 yayınına düşer (canlı sürüm)
calistir(realpath(__DIR__ . '/../v-1'), $uri);
