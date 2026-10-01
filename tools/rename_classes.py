#!/usr/bin/env python3
"""
v-1 class adlarını class-map.json'a göre (Türkçe → İngilizce) yeniden adlandırır.

Sadece class bağlamlarında değiştirir; PHP dizi anahtarları, bölüm tipleri
('tip' => 'metin-gorsel'), fonksiyon adları ve veri dosyalarına dokunmaz.

Kullanım (proje kökünden):
  python3 tools/rename_classes.py --dry-run            # ne değişeceğini sayar, yazmaz
  python3 tools/rename_classes.py --apply              # dosyalara yazar
  python3 tools/rename_classes.py --snapshot once.json # sayfaların class'larını kaydeder
  python3 tools/rename_classes.py --verify once.json   # önce/sonra karşılaştırır
"""
import argparse
import glob
import json
import os
import re
import sys
import urllib.request

KOK = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
V1 = os.path.join(KOK, 'v-1')
HARITA = json.load(open(os.path.join(KOK, 'class-map.json'), encoding='utf-8'))

# Bölüm tipleri (includes/bolumler/*.php adları) aynı zamanda veri değeri;
# bunlar yalnızca gerçek class bağlamında değişir.
TIPLER = {os.path.splitext(os.path.basename(f))[0]
          for f in glob.glob(os.path.join(V1, 'includes/bolumler/*.php'))}

SINIR_ONCE = r'(?<![A-Za-z0-9_-])'
SINIR_SONRA = r'(?![A-Za-z0-9_-])'
# Uzun adlar önce (ör. "kart__gorsel" "kart"tan önce)
ANAHTARLAR = sorted(HARITA, key=len, reverse=True)
TOKEN_RE = re.compile(SINIR_ONCE + '(' + '|'.join(map(re.escape, ANAHTARLAR)) + ')' + SINIR_SONRA)
NOKTALI_RE = re.compile(r'\.(' + '|'.join(map(re.escape, ANAHTARLAR)) + ')' + SINIR_SONRA)

SAYFALAR = ['/', '/kurumsal.php', '/subeler.php', '/hizmetler.php', '/menu.php',
            '/iletisim.php', '/rezervasyon.php', '/kvkk.php', '/gizlilik.php',
            '/cerez.php', '/ik.php', '/sube.php?s=uckuyular', '/sube.php?s=narlidere',
            '/sube.php?s=bostanli', '/iletisim.php?form=tamam', '/iletisim.php?form=hata',
            '/rezervasyon.php?form=tamam', '/rezervasyon.php?form=hata']


def token_degistir(metin, sadece_bilesik=False):
    def f(m):
        t = m.group(1)
        if sadece_bilesik and ('-' not in t and '_' not in t):
            return t
        return HARITA[t]
    return TOKEN_RE.sub(f, metin)


def css_isle(metin):
    """Yalnızca seçici (prelude) kısımlarında .eski → .yeni."""
    cikti, i, baslangic = [], 0, 0
    sayi = 0
    while i < len(metin):
        if metin.startswith('/*', i):
            son = metin.find('*/', i + 2)
            i = len(metin) if son == -1 else son + 2
            continue
        c = metin[i]
        if c in '};':
            cikti.append(metin[baslangic:i + 1])
            baslangic = i + 1
        elif c == '{':
            prelude = metin[baslangic:i]
            yeni, n = NOKTALI_RE.subn(lambda m: '.' + HARITA[m.group(1)], prelude)
            sayi += n
            cikti.append(yeni + '{')
            baslangic = i + 1
        i += 1
    cikti.append(metin[baslangic:])
    return ''.join(cikti), sayi


PHP_BLOK_RE = re.compile(r'<\?(?:php|=)?.*?\?>', re.S)
SINIF_ATTR_RE = re.compile(r'(\bclass(?:Name)?\s*[=:]\s*\\?)(["\'])(.*?)(\\?\2)', re.S)


def sinif_degeri_isle(deger):
    """class="..." değeri: statik kısımlarda tüm token'lar, PHP kısımlarında
    yalnızca tire/alt çizgili token'lar (tek kelimelik PHP değişken/anahtarları korunur)."""
    parcalar, son = [], 0
    for m in PHP_BLOK_RE.finditer(deger):
        parcalar.append(token_degistir(deger[son:m.start()]))
        parcalar.append(token_degistir(m.group(0), sadece_bilesik=True))
        son = m.end()
    parcalar.append(token_degistir(deger[son:]))
    return ''.join(parcalar)


PHP_DIZGI_RE = re.compile(r"'(?:[^'\\]|\\.)*'|\"(?:[^\"\\]|\\.)*\"", re.S)
BOLUM_AC_RE = re.compile(r"(bolum_ac\(\s*\$b\s*,\s*)'([^']*)'")


def php_isle(metin):
    once = metin
    # 1) class="..." / class=\"...\" değerleri
    metin = SINIF_ATTR_RE.sub(lambda m: m.group(1) + m.group(2) + sinif_degeri_isle(m.group(3)) + m.group(4), metin)
    # 2) bolum_ac($b, '...') ilk dizgesi: class listesidir
    metin = BOLUM_AC_RE.sub(lambda m: m.group(1) + "'" + token_degistir(m.group(2)) + "'", metin)

    # 3) Diğer PHP dizgeleri: yalnızca tire/alt çizgili ve bölüm tipi OLMAYAN token'lar
    #    (ör. ' metin-gorsel--tam', 'harita__isaret'); 'tip' => 'metin-gorsel' korunur.
    def dizgi(m):
        s = m.group(0)
        def f(t):
            k = t.group(1)
            if ('-' not in k and '_' not in k) or k in TIPLER:
                return k
            return HARITA[k]
        return TOKEN_RE.sub(f, s)
    parcalar, son = [], 0
    for m in re.finditer(r'<\?(?:php|=)?(.*?)(?:\?>|\Z)', metin, re.S):
        parcalar.append(metin[son:m.start()])
        parcalar.append(PHP_DIZGI_RE.sub(dizgi, m.group(0)))
        son = m.end()
    parcalar.append(metin[son:])
    metin = ''.join(parcalar)
    return metin, degisim_sayisi(once, metin)


JS_DIZGI_RE = re.compile(r"'(?:[^'\\\n]|\\.)*'|\"(?:[^\"\\\n]|\\.)*\"")
CLASSLIST_RE = re.compile(r"(classList\.(?:add|remove|toggle|contains)\(\s*)(['\"])([^'\"]*)(\2)")


def js_isle(metin):
    once = metin
    metin = CLASSLIST_RE.sub(lambda m: m.group(1) + m.group(2) + token_degistir(m.group(3)) + m.group(4), metin)
    # Dizge içindeki seçiciler (.eski) ve üretilen HTML'deki class="..." değerleri
    def dizgi(m):
        s = NOKTALI_RE.sub(lambda t: '.' + HARITA[t.group(1)], m.group(0))
        s = SINIF_ATTR_RE.sub(lambda t: t.group(1) + t.group(2) + token_degistir(t.group(3)) + t.group(4), s)
        return s
    metin = JS_DIZGI_RE.sub(dizgi, metin)
    # className: '...'
    metin = re.sub(r"(className\s*:\s*)(['\"])([^'\"]*)(\2)",
                   lambda m: m.group(1) + m.group(2) + token_degistir(m.group(3)) + m.group(4), metin)
    return metin, degisim_sayisi(once, metin)


def degisim_sayisi(a, b):
    if a == b:
        return 0
    return sum(1 for x, y in zip(a.splitlines(), b.splitlines()) if x != y)


def dosyalar():
    css = sorted(glob.glob(os.path.join(V1, 'assets/css/*.css')))
    php = sorted(glob.glob(os.path.join(V1, 'includes/*.php'))
                 + glob.glob(os.path.join(V1, 'includes/bolumler/*.php'))
                 + glob.glob(os.path.join(V1, '*.php')))
    php = [p for p in php if os.path.basename(p) != 'router.php']
    js = sorted(glob.glob(os.path.join(V1, 'assets/js/*.js')))
    return css, php, js


def calistir(yaz):
    css, php, js = dosyalar()
    toplam = 0
    sonuc = {}
    for liste, fn in ((css, css_isle), (php, php_isle), (js, js_isle)):
        for yol in liste:
            eski = open(yol, encoding='utf-8').read()
            yeni, n = fn(eski)
            sonuc[yol] = yeni
            if yeni != eski:
                toplam += 1
                print(f'  {os.path.relpath(yol, KOK)}: {n} satır')
                if yaz:
                    open(yol, 'w', encoding='utf-8').write(yeni)
    print(f'{toplam} dosya {"yazıldı" if yaz else "değişecek (dry-run)"}')

    # Dinamik önekler: araç bunlara dokunmaz, elle çevrilecek
    print('\nElle bakılacak dinamik önekler:')
    for yol, metin in sonuc.items():
        for no, satir in enumerate(metin.splitlines(), 1):
            if re.search(r"--'\s*\.|--%s|'gorsel '", satir):
                print(f'  {os.path.relpath(yol, KOK)}:{no}: {satir.strip()[:110]}')


SINIF_HTML_RE = re.compile(r'class="([^"]*)"')


def sayfa_siniflari(taban):
    sonuc = {}
    for s in SAYFALAR:
        with urllib.request.urlopen(taban + s) as y:
            html = y.read().decode('utf-8')
        sonuc[s] = [' '.join(m.group(1).split()) for m in SINIF_HTML_RE.finditer(html)]
    return sonuc


def main():
    p = argparse.ArgumentParser()
    g = p.add_mutually_exclusive_group(required=True)
    g.add_argument('--dry-run', action='store_true')
    g.add_argument('--apply', action='store_true')
    g.add_argument('--snapshot')
    g.add_argument('--verify')
    p.add_argument('--base', default='http://localhost:8081')
    a = p.parse_args()

    if a.dry_run or a.apply:
        calistir(yaz=a.apply)
        return
    if a.snapshot:
        json.dump(sayfa_siniflari(a.base), open(a.snapshot, 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
        print('kaydedildi:', a.snapshot)
        return

    once = json.load(open(a.verify, encoding='utf-8'))
    simdi = sayfa_siniflari(a.base)
    hata = 0
    for s in SAYFALAR:
        beklenen = [' '.join(HARITA.get(t, t) for t in v.split()) for v in once.get(s, [])]
        gercek = simdi[s]
        if beklenen != gercek:
            hata += 1
            print(f'FARK {s}: {len(beklenen)} / {len(gercek)} class özniteliği')
            for i, (x, y) in enumerate(zip(beklenen, gercek)):
                if x != y:
                    print(f'   #{i} beklenen: {x}\n      gerçek:   {y}')
                    break
    # Sayfada kalan eski ad var mı?
    kalan = sorted({t for v in simdi.values() for c in v for t in c.split() if t in HARITA})
    print('Sayfalarda kalan eski class:', kalan or 'yok')
    print('SONUÇ:', 'TAMAM' if hata == 0 and not kalan else f'{hata} sayfada fark')
    sys.exit(0 if hata == 0 and not kalan else 1)


if __name__ == '__main__':
    main()
