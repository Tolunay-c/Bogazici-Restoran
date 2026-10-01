<?php
declare(strict_types=1);

/* PHP 7.4 uyumluluğu (sunucu PHP 8 değilse) */
if (!function_exists('str_starts_with')) {
    function str_starts_with(string $metin, string $on): bool { return $on === '' || strncmp($metin, $on, strlen($on)) === 0; }
}
if (!function_exists('str_ends_with')) {
    function str_ends_with(string $metin, string $son): bool { return $son === '' || substr($metin, -strlen($son)) === $son; }
}
if (!function_exists('str_contains')) {
    function str_contains(string $metin, string $parca): bool { return $parca === '' || strpos($metin, $parca) !== false; }
}


/** HTML kaçışı — çıktı veren her yerde zorunlu. */
function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** "yemek.webp" + 960  ->  "/assets/img/yemek-960.webp" */
function gorsel_url(string $dosya, ?int $genislik = null): string
{
    if ($dosya === '') {
        return '';
    }
    // Vercel Blob gibi tam URL'ler: türev adı uzantıdan önce eklenir
    if (preg_match('#^https?://#i', $dosya)) {
        if ($genislik === null) {
            return $dosya;
        }
        return preg_replace('#\.([a-z0-9]+)$#i', '-' . $genislik . '.$1', $dosya) ?? $dosya;
    }
    if ($genislik === null) {
        return GORSEL_YOL . '/' . $dosya;
    }
    $uzanti = pathinfo($dosya, PATHINFO_EXTENSION);
    $ad     = pathinfo($dosya, PATHINFO_FILENAME);
    $klasor = trim(pathinfo($dosya, PATHINFO_DIRNAME), '.');

    return GORSEL_YOL . ($klasor !== '' ? '/' . trim($klasor, '/') : '') . "/{$ad}-{$genislik}.{$uzanti}";
}

function gorsel_srcset(string $dosya): string
{
    $parcalar = [];
    foreach (GORSEL_TUREVLERI as $g) {
        $parcalar[] = gorsel_url($dosya, $g) . " {$g}w";
    }
    return implode(', ', $parcalar);
}

/**
 * Tek görsel etiketi.
 *
 * @param array{
 *   alt?:string, oran?:string, odak?:string, sinif?:string,
 *   oncelik?:bool, mobil?:string
 * } $o
 */
function gorsel(string $dosya, string $sizes, array $o = []): string
{
    if ($dosya === '') {
        return '';
    }

    $alt     = $o['alt']     ?? '';
    $oran    = $o['oran']    ?? '';
    $odak    = ODAK_HARITASI[$o['odak'] ?? 'merkez'] ?? ODAK_HARITASI['merkez'];
    $sinif   = trim('image ' . ($o['sinif'] ?? ''));
    $oncelik = (bool) ($o['oncelik'] ?? false);

    $stil = "--odak:{$odak}" . ($oran !== '' ? ";--oran:{$oran}" : '');

    // Galeride oran serbest ama width/height ZORUNLU (CLS).
    // Panel görseli yüklerken gerçek en/boy değerini kaydeder.
    $en  = (int) ($o['en']  ?? 1600);
    $boy = (int) ($o['boy'] ?? 1067);

    $img = sprintf(
        '<img src="%s" srcset="%s" sizes="%s" alt="%s" class="%s" style="%s" width="%d" height="%d" %s>',
        e(gorsel_url($dosya, 1440)),
        e(gorsel_srcset($dosya)),
        e($sizes),
        e($alt),
        e($sinif),
        e($stil),
        $en,
        $boy,
        $oncelik ? 'loading="eager" fetchpriority="high" decoding="sync"' : 'loading="lazy" decoding="async"'
    );

    // Ayrı mobil görseli varsa <picture> ile sanat yönetimi
    if (!empty($o['mobil'])) {
        return sprintf(
            '<picture><source media="(max-width:639px)" srcset="%s" sizes="100vw">%s</picture>',
            e(gorsel_srcset($o['mobil'])),
            $img
        );
    }

    return $img;
}

/** Tek bölümü basar. $b['tip'] -> includes/bolumler/{tip}.php */
function bolum(array $b): void
{
    $tip = preg_replace('/[^a-z0-9\-]/', '', (string) ($b['tip'] ?? ''));
    if ($tip === '') {
        return;
    }
    $yol = __DIR__ . "/bolumler/{$tip}.php";
    if (!is_file($yol)) {
        return;
    }
    if (isset($b['aktif']) && !$b['aktif']) {
        return;
    }
    include $yol;   // $b partial içinde görünür
}

/** Bir sayfanın bölüm dizisini sırayla basar. */
function bolumleri_yaz(array $bolumler): void
{
    foreach ($bolumler as $b) {
        bolum($b);
    }
}

/**
 * Bölüm sarmalayıcı açılışı. Zemin ritmi ve boşluk çakışması
 * tamamen CSS'te çözülür (bkz. bolumler.css > "zemin ritmi").
 */
function bolum_ac(array $b, string $ekSinif = ''): string
{
    $zemin = in_array($b['zemin'] ?? 'beyaz', ['beyaz', 'kum', 'koyu'], true)
        ? $b['zemin'] ?? 'beyaz'
        : 'beyaz';

    return sprintf(
        '<section class="section %s" data-zemin="%s"%s>',
        e(trim($ekSinif)),
        e($zemin),
        !empty($b['kimlik']) ? ' id="' . e($b['kimlik']) . '"' : ''
    );
}

/** Üstlük + başlık + alt başlık üçlüsü — panelde her bölümde var. */
function bolum_basligi(array $b, string $hizalama = 'sol', string $etiket = 'h2'): string
{
    if (empty($b['baslik']) && empty($b['ustluk'])) {
        return '';
    }
    $c  = '<header class="section-heading section-heading--' . e(['sol' => 'left', 'orta' => 'center', 'sag' => 'right'][$hizalama] ?? 'left') . '">';
    if (!empty($b['ustluk'])) {
        $c .= '<p class="eyebrow">' . e($b['ustluk']) . '</p>';
    }
    if (!empty($b['baslik'])) {
        $c .= "<{$etiket} class=\"section-heading__title\">" . e($b['baslik']) . "</{$etiket}>";
    }
    if (!empty($b['alt_baslik'])) {
        $c .= '<p class="section-heading__sub">' . e($b['alt_baslik']) . '</p>';
    }
    return $c . '</header>';
}

/** Birincil/ikincil buton — boş alan gelirse hiç basmaz. */
function buton(?string $yazi, ?string $link, string $tur = 'birincil', string $ek = ''): string
{
    if (empty($yazi) || empty($link)) {
        return '';
    }
    $turSinif = ['birincil' => 'primary', 'ikincil' => 'secondary', 'duz' => 'text'][$tur] ?? $tur;
    return sprintf(
        '<a class="btn btn--%s %s" href="%s">%s</a>',
        e($turSinif),
        e($ek),
        e($link),
        e($yazi)
    );
}
