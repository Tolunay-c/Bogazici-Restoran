<?php
chdir(__DIR__ . '/../v-1');

// İstek yapılan dosya yolunu al (örn: /iletisim.php -> iletisim.php)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = ltrim($uri, '/');

// Eğer kök dizin ise veya dosya belirtilmemişse index.php aç
if ($file === '' || $file === '/') {
    require __DIR__ . '/../v-1/index.php';
    exit;
}

// Güvenli dosya kontrolü: İstenen PHP dosyası v-1 altında var mı?
$target = realpath(__DIR__ . '/../v-1/' . $file);
$baseDir = realpath(__DIR__ . '/../v-1');

if ($target && str_starts_with($target, $baseDir) && file_exists($target) && !is_dir($target)) {
    require $target;
} else {
    // Bulunamazsa index.php'ye yönlendir
    require __DIR__ . '/../v-1/index.php';
}