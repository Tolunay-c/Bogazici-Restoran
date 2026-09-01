<?php
declare(strict_types=1);

/** HTML kaçışı — çıktı veren her yerde zorunlu. */
function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** CSRF üret / doğrula (rezervasyon formu için). */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_dogrula(?string $gonderilen): bool
{
    return is_string($gonderilen)
        && !empty($_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $gonderilen);
}

/**
 * "yemek.webp" + 960 -> "/assets/img/yemek-960.webp"
 * YEREL modda dosya yoksa data:URI SVG yer tutucu döner — bu sayede
 * router.php'siz sunucularda (MAMP/Apache/normal `php -S`) da çalışır.
 */
function gorsel_url(string $dosya, ?int $genislik = null): string
{
    if ($dosya === '') return '';

    if ($genislik === null) {
        $goreli = '/' . $dosya;
    } else {
        $uzanti = pathinfo($dosya, PATHINFO_EXTENSION);
        $ad     = pathinfo($dosya, PATHINFO_FILENAME);
        $klasor = trim(pathinfo($dosya, PATHINFO_DIRNAME), '.');
        $goreli = ($klasor !== '' ? '/' . trim($klasor, '/') : '')
                . "/{$ad}-{$genislik}.{$uzanti}";
    }

    $url = GORSEL_YOL . $goreli;

    // Geliştirme: dosya diskte yoksa inline SVG döndür.
    if (YEREL && !is_file(SITE_KOK . $url)) {
        return gorsel_yer_tutucu($dosya, $genislik);
    }

    return $url;
}

/**
 * Dev için inline SVG yer tutucu (data: URI). Router.php'ye ihtiyaç yok.
 * Prefix'lere göre oran tahmin eder — hero 16:9, sube 4:3, urun 1:1, hikaye 4:5.
 */
function gorsel_yer_tutucu(string $dosya, ?int $genislik = null): string
{
    $ad = pathinfo($dosya, PATHINFO_FILENAME);
    $en = $genislik ?? 1440;

    $oran = 3 / 2;
    if (str_starts_with($ad, 'hero') || str_starts_with($ad, 'basluk')) {
        $oran = str_contains($ad, 'mobil') ? 4 / 5 : 16 / 9;
    } elseif (str_starts_with($ad, 'sube')) {
        $oran = 4 / 3;
    } elseif (str_starts_with($ad, 'urun')) {
        $oran = 1;
    } elseif (str_starts_with($ad, 'hikaye')) {
        $oran = 4 / 5;
    } elseif (str_starts_with($ad, 'galeri')) {
        $oranlar = [3 / 4, 4 / 3, 2 / 3, 1, 3 / 2, 4 / 5];
        $oran = $oranlar[abs(crc32($ad)) % count($oranlar)];
    }

    $boy    = (int) round($en / $oran);
    $etiket = htmlspecialchars($ad . ' · ' . $en . '×' . $boy, ENT_QUOTES);
    $punto  = max(14, (int) round($en / 26));
    $tonlar = ['#E9E1D3', '#D9CFBD', '#F0E9DA', '#C9BEA8'];
    $ton    = $tonlar[abs(crc32($ad)) % count($tonlar)];

    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {$en} {$boy}" width="{$en}" height="{$boy}"><rect width="100%" height="100%" fill="{$ton}"/><text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" fill="#0E1B2C" fill-opacity=".5" font-family="ui-serif,Georgia,serif" font-size="{$punto}">{$etiket}</text></svg>
SVG;

    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

/** Slug -> şube dizisi. Bulunamazsa ilk şubeyi döner. */
function sube_bul(string $slug): array
{
    foreach (SUBELER as $s) {
        if ($s['slug'] === $slug) return $s;
    }
    return SUBELER[0];
}

/** Rezervasyon için servise göre gruplu saat listesi. */
function saat_secenekleri(): array
{
    return [
        'ogle'  => ['12:00','12:30','13:00','13:30','14:00','14:30','15:00'],
        'aksam' => ['18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30'],
    ];
}

/** Doğrulama için düz saat listesi. */
function saat_hepsi(): array
{
    $gruplar = saat_secenekleri();
    return array_merge(...array_values($gruplar));
}

/** Tek bölümü basar. $b['tip'] -> includes/bolumler/{tip}.php */
function bolum(array $b): void
{
    $tip = preg_replace('/[^a-z0-9\-]/', '', (string)($b['tip'] ?? ''));
    if ($tip === '') return;
    $yol = __DIR__ . "/bolumler/{$tip}.php";
    if (!is_file($yol)) return;
    if (isset($b['aktif']) && !$b['aktif']) return;
    include $yol;   // $b partial içinde görünür
}

/** Bir sayfanın bölüm dizisini sırayla basar. */
function bolumleri_yaz(array $bolumler): void
{
    foreach ($bolumler as $b) bolum($b);
}

