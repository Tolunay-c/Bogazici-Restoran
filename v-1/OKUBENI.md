# Boğaziçi Restaurant — tasarım sistemi iskeleti

## Kurulum
1. Fontları indir (google-webfonts-helper, subset: **latin + latin-ext**, format woff2, variable):
   - `assets/fonts/inter-latin.woff2`, `inter-latin-ext.woff2`
   - `assets/fonts/playfair-latin.woff2`, `playfair-latin-ext.woff2`
2. Görselleri `assets/img/` altına koy. Panel her yükleme için `-480 / -960 / -1440 / -2200` türevlerini üretecek.
   Örn: `hero-anasayfa.webp` -> `hero-anasayfa-960.webp`
3. `config.php` içindeki SITE_URL / telefon değerlerini güncelle.

## Logo geldiğinde
`assets/css/tokens.css` -> "1. katman" bloğundaki 6 hex değeri değiştir. Başka dosyaya dokunma.
Hiçbir bileşende ham hex yok; hepsi semantik token üzerinden geçiyor.

## Veritabanına geçiş
`data/icerik.php` yerine sorgu katmanı gelecek. Dizi şeması = tablo şeması:

bolumler(id, sayfa, tip, sira, aktif, zemin, kimlik, ustluk, baslik, alt_baslik,
         metin, gorsel, gorsel_mobil, gorsel_odak, gorsel_alt,
         buton_yazi, buton_link, buton2_yazi, buton2_link)
bolum_ogeleri(id, bolum_id, sira, baslik, metin, gorsel, gorsel_alt, link, fiyat, sayi, etiket)

`bolumleri_yaz($sayfalar['anasayfa'])` çağrısı aynı kalır.

## Yeni bölüm tipi eklemek
`includes/bolumler/{tip}.php` dosyası aç, `bolum_ac($b, 'sinif')` ile başla, `</section>` ile bitir.
`bolum()` fonksiyonu tipi dosya adına eşliyor; kayıt/switch yok.

## Kurallar
- Hover/hareket yalnızca tıklanabilir öğede, `@media (hover:hover)` içinde.
- Gölge yalnızca drawer / lightbox / harita kartı. Kartlarda 1px hairline.
- Display fontu 500 ağırlık, sadece 3xl ve üstü.
- Aksan rengi metin olarak kullanılmaz; `--vurgu-metin` var.
- Bölüm boşluğu tek token (`--bolum`), aynı zeminli komşularda CSS otomatik sıfırlıyor.

## Henüz yazılmadı (sıradaki adım)
- rezervasyon.php + SVG kroki + saat dilimi seçici
- menu.php (alacarte / paket ayrımı)
- sube.php (tek şablon, 3 şube)
- galeri.php (sayfalı yükleme)
- admin panel
