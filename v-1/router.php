<?php
/* --------------------------------------------------------------
   SADECE GELİŞTİRME İÇİN
   Kullanım:  php -S localhost:8000 router.php
   Canlı sunucuya YÜKLEME. Apache/Nginx bu dosyayı zaten çalıştırmaz.

   Görev: /assets/img/ altındaki eksik dosyalara doğru ölçüde
   SVG yer tutucu döndürmek. Böylece fotoğraflar gelmeden
   yerleşim ve oranlar gerçekçi görünür.
   -------------------------------------------------------------- */

$yol = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$tam = __DIR__ . $yol;

// Gerçekten var olan dosyaları PHP'nin kendi sunucusuna bırak
if ($yol !== '/' && file_exists($tam) && !is_dir($tam)) {
    return false;
}

// Eksik görsel -> SVG yer tutucu
if (preg_match('#^/assets/img/(.+)\.(webp|jpg|jpeg|png|svg)$#i', $yol, $m)) {
    $ad = $m[1];

    // Dosya adındaki -960 gibi son ek genişliği verir
    $genislik = 1440;
    if (preg_match('/-(\d{3,4})$/', $ad, $g)) {
        $genislik = (int) $g[1];
        $ad = preg_replace('/-\d{3,4}$/', '', $ad);
    }

    // İsimden oran tahmini — bölüm kataloğundaki oranlarla aynı
    $oran = 3 / 2;
    if (str_starts_with($ad, 'hero') || str_starts_with($ad, 'basluk')) {
        $oran = str_contains($ad, 'mobil') ? 4 / 5 : 16 / 9;
    } elseif (str_starts_with($ad, 'sube')) {
        $oran = 4 / 3;
    } elseif (str_starts_with($ad, 'urun')) {
        $oran = 1;
    } elseif (str_starts_with($ad, 'galeri')) {
        // Galeride masonry'yi test edebilmek için oranları kasten karıştır
        $oranlar = [3 / 4, 4 / 3, 2 / 3, 1, 3 / 2, 4 / 5];
        $oran = $oranlar[abs(crc32($ad)) % count($oranlar)];
    }

    $yukseklik = (int) round($genislik / $oran);
    $etiket    = htmlspecialchars($ad . ' · ' . $genislik . '×' . $yukseklik, ENT_QUOTES);
    $punto     = max(14, (int) round($genislik / 26));
    $tonlar    = ['#C9C3B8', '#B7B0A4', '#D3CEC4', '#A9A296'];
    $ton       = $tonlar[abs(crc32($ad)) % count($tonlar)];

    header('Content-Type: image/svg+xml');
    header('Cache-Control: no-store');
    echo <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {$genislik} {$yukseklik}" width="{$genislik}" height="{$yukseklik}">
  <rect width="100%" height="100%" fill="{$ton}"/>
  <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle"
        fill="#0E1F26" fill-opacity=".5" font-family="ui-sans-serif,system-ui,sans-serif"
        font-size="{$punto}">{$etiket}</text>
</svg>
SVG;
    return true;
}

// Eksik font -> sessizce 404, fallback font devreye girer
if (preg_match('#^/assets/fonts/#', $yol)) {
    http_response_code(404);
    return true;
}

return false;
