# Revize Tamamlananlar — v-2

Bu dosya `v-1/revizeler.md` üzerinden istenen tüm değişikliklerin
v-2 klasöründe hangi dosyalara nasıl uygulandığını maddeler halinde tutar.

---

## 1. GENEL — Şubeler, telefon, e-posta

- **Şube isimleri değişti:** Alsancak/Çeşme/Karşıyaka → **Üçkuyular / Narlıdere / Bostanlı**.
- **Telefon** her yerde `0850 850 0850` (tel: `+908508500850`).
- **Genel e-posta** `info@bogazicirestaurant.com.tr`, şubelere özel:
  `uckuyular@…`, `narlidere@…`, `bostanli@…`.
- **Adresler** revizyondaki değerlerle:
  - Üçkuyular: Bahçeler Arası Mah. Haydar Aliyev Bulvarı No: 2/A, Balçova / İzmir
  - Narlıdere: Limanreis Mah. Mithatpaşa Cd. No: 606, 35320 Narlıdere / İzmir
  - Bostanlı: Cengiz Topel Caddesi No: 38/B, Bostanlı – İzmir
- **Koordinatlar** yaklaşık (Leaflet haritalar için placeholder olarak eklendi).
- Değişen dosyalar: `v-2/data/icerik.php` (SUBELER sabiti),
  `v-2/includes/header.php`, `v-2/includes/footer.php`,
  `v-2/kvkk.php` (telefon), `v-2/includes/bolumler/iletisim-form.php`.

## 2. ANASAYFA

- **Hero:** "BOĞAZİÇİ RESTAURANT · İzmir'de Lezzetin Buluşma Noktası" +
  alt metin + "Şubelerimizi Keşfedin" & "Rezervasyon" butonları +
  "Üçkuyular · Narlıdere · Bostanlı" ek yazısı.
- "Yemekte Boğaziçi Dokunuşu" hikâye bloğu (Özenli Mutfak / Kaliteli Hizmet /
  Keyifli Atmosfer değerleriyle).
- "Size En Yakın Boğaziçi" — 3 şube kartı (`sube-onizleme`).
- "Her Sofraya Bir Boğaziçi Klasiği" menü CTA bloğu (Menüyü İncele butonuyla).
- "Boğaziçi'nden Kareler" — yeni `sube-kareler` bloğu, tıklandığında
  şubeler sayfasındaki ilgili şubeye götürüyor.
- "Yeriniz Hazır" rezervasyon kapanışı (Rezervasyon Yap + Şubeleri Gör).
- Kaldırılanlar: eski "Denizin sofraya en kısa yolu" hero'su, "günlük
  tezgâh" hikâyeleri, "eski demo" bölümleri.
- Değişen dosyalar: `v-2/data/icerik.php` (`$sayfalar['anasayfa']`),
  yeni partial `v-2/includes/bolumler/sube-kareler.php`.

## 3. ŞUBELER

- **Hero:** "BOĞAZİÇİ RESTAURANT · Üç Şube, Tek Boğaziçi Deneyimi" +
  revizyondaki alt metin.
- 3 `sube-detay` bloğu — yeni slug/ad/metin:
  1) `uckuyular` — Balçova/Haydar Aliyev; 2) `narlidere` — Mithatpaşa;
  3) `bostanli` — Cengiz Topel (1993 orijinal şube).
- "Boğaziçi'nde Buluşalım" ile "Üç Farklı Lokasyon, Aynı Boğaziçi" kapanışına
  birleştirildi; rezervasyon butonu tek buton olarak korundu.
- **Görsel yerine harita:** her şube kartında Leaflet + OSM haritası
  (`data-harita-lat/lng/etiket`). `subeler.php` sayfasına
  `$sayfa_leaflet = true` ve `$sayfa_js = 'harita.js'` eklendi.
- Değişen dosyalar: `v-2/data/icerik.php`, `v-2/subeler.php`,
  `v-2/includes/bolumler/sube-detay.php` (image → harita div, e-posta,
  /v-2/rezervasyon.php link).

## 4. KURUMSAL

- **Hero:** "1993'ten Bugüne, Aynı Özenle" + Bostanlı/Üçkuyular/Narlıdere
  vurgusu.
- "HİKÂYEMİZ · İzmir'de Bir Boğaziçi Klasiği" — 1993 Bostanlı, 2010
  Üçkuyular, 2017 Narlıdere anlatısı (uzun "Hakkımızda" metni değil).
- **Yatay zaman çizgisi:** 1993 → 2010 → 2017 → BUGÜN.
- **"Değişmeyen Değerler":** Kalite, Özen, Misafirperverlik (eski
  "günlük tedarik / tek tarif defteri / sabit ekip" bölümü kaldırıldı).
- **"MUTFAK ANLAYIŞIMIZ · Lezzetin Temelinde Kalite Var"** + slogan
  bloğu: **"İyi Ye, İyi Yaşa."** (`alinti` bloğu ile).
- **"KALİTE & HİJYEN · Kalite, Boğaziçi'nin Temelidir"** — et/balık ayrı
  mutfak vurgusu, ama eski uzun metin taşınmadan.
- Kapanış: "Boğaziçi Deneyimini Keşfedin" + Şubelerimiz & Rezervasyon
  ikili butonu.
- Değişen dosyalar: `v-2/data/icerik.php` (`$sayfalar['kurumsal']`),
  `v-2/includes/bolumler/kapanis.php` (ikinci buton desteği).

## 5. MENÜ

- **Hero:** "MENÜ · Boğaziçi Mutfağını Keşfedin" + mevsimsel/şubesel
  fark notu tek satırda.
- Kategoriler revizyondaki gibi 6'ya çekildi:
  Mezeler · Ara Sıcaklar · Balık & Deniz Ürünleri · Et & Izgara ·
  Salatalar · Tatlılar.
- Kapanış: "Boğaziçi Sofrasında Yerinizi Ayırtın" + Rezervasyon + Şubelerimiz.
- Kaldırılanlar: eski "İçecekler" kategorisi (menüde reklam ağırlığı vardı),
  "Masanızı ayırtın" reklam cümlesi.
- Değişen dosya: `v-2/data/icerik.php` (`$sayfalar['menu']`).

## 6. HİZMETLER

- **Hero:** "Her Buluşmaya Boğaziçi Dokunuşu".
- 4 hizmet bloğu revizyondaki başlıklarla:
  01 İş Toplantıları & Seminerler → **Bilgi Al**
  02 Kokteyl & Etkinlik (ters yerleşim) → **Organizasyon Bilgisi Al**
  03 Catering (100 kişiye kadar) → **Catering İçin Bilgi Al**
  04 Paket Servis → **Paket Servis Bilgi Al**
- Kapanış: "İhtiyacınıza Özel Çözümler" + Bilgi Alın & İletişim ikili buton.
- Değişen dosya: `v-2/data/icerik.php` (`$sayfalar['hizmetler']`).

## 7. GALERİ

- **Ana menüden ve footer'dan tamamen kaldırıldı.**
- `v-2/galeri.php` dosyası duruyor ancak nav bağlantıları yok.
- `$sayfalar['galeri']` da placeholder'a indirildi.
- Değişen dosyalar: `v-2/includes/header.php`, `v-2/includes/footer.php`,
  `v-2/data/icerik.php`.

## 8. İLETİŞİM

- **Hero:** "Bizimle İletişime Geçin" + kısa alt metin (uzun eski metin
  değil).
- **Form:** mevcut Ad Soyad / E-posta / Telefon / Konu / Mesaj + KVKK
  onayı düzeni korundu; sidebar'daki "Alsancak — merkez" → "Genel
  iletişim hattı" + Bostanlı adresi. Yalnız `info@` kaldı, `etkinlik@`
  kaldırıldı. "Anında onay" reklam cümlesi zaten yoktu; sidebar
  konseptine dokunulmadı.
- **3 Şube kartı:** `sube-onizleme` bloğu yeniden kullanıldı; kartlara
  şube e-postası + yol tarifi butonu eklendi.
- **Sekmeli tek harita:** yeni `harita-sekmeli` bloğu — Leaflet + OSM.
  Üçkuyular / Narlıdere / Bostanlı sekmeleri arasında panning + marker,
  altında "Google Maps'te Aç →" bağlantısı.
- **Genel İletişim** şeridi: `genel-iletisim` bloğu — büyük tipografiyle
  0850 telefon + info@ e-posta.
- Değişen dosyalar: `v-2/data/icerik.php` (`$sayfalar['iletisim']`),
  `v-2/iletisim.php` ($sayfa_leaflet, $sayfa_js),
  `v-2/includes/bolumler/iletisim-form.php`,
  yeni partial'lar: `harita-sekmeli.php`, `genel-iletisim.php`,
  yeni JS: `v-2/assets/js/harita.js`.

## 9. FOOTER

- **4 kolon** — lacivert zemin, beyaz/kırık beyaz metin (`.alt` stilleri).
  1) Marka: "BOĞAZİÇİ RESTAURANT" + 1993 sloganı + "İyi Ye, İyi Yaşa" +
     Instagram/Facebook.
  2) Hızlı Erişim: Ana Sayfa · Kurumsal · Şubelerimiz · Menü · Hizmetler ·
     İletişim · Rezervasyon (Galeri **yok**).
  3) Şubelerimiz: 3 slug bağlantısı (`#sube-<slug>`) + 0850 + info@.
  4) Kurumsal: İnsan Kaynakları · KVKK Metni · Çerez Aydınlatma Metni ·
     Gizlilik Politikası.
- Alt telif satırı: `© 2026 Boğaziçi Restaurant …` + KVKK · Çerez · Gizlilik
  hızlı bağlantıları.
- **Yeni yasal sayfa:** `v-2/cerez.php` (Çerez Aydınlatma Metni taslağı).
- Değişen dosyalar: `v-2/includes/footer.php`, yeni `v-2/cerez.php`,
  `v-2/assets/css/bolumler.css` (marka slogan, moto, sosyal, iletişim,
  telif bağlantı stilleri).

## 10. HEADER / ÜST MENÜ

- Sıra: **Ana Sayfa (logo) · Kurumsal · Şubeler · Menü · Hizmetler ·
  İletişim · Rezervasyon (buton)** — Galeri kaldırıldı.
- Utility strip'te telefon `0850 850 0850`, alt yazı "Üçkuyular · Narlıdere
  · Bostanlı".
- Mobil çekmece de aynı şekilde güncellendi.
- Değişen dosya: `v-2/includes/header.php`.

## 11. REZERVASYON

- Default `sube` slug'ı `alsancak` → `uckuyular` yapıldı.
- Form action `/rezervasyon.php` → `/v-2/rezervasyon.php`.
- KVKK bağlantısı `/kvkk.php` → `/v-2/kvkk.php`.
- SVG kroki yerleşimi ve saat grupları önceki revizyondan olduğu gibi
  korundu.
- Değişen dosya: `v-2/rezervasyon.php`.

## 12. YENİ CSS / JS

- `v-2/assets/css/bolumler.css` sonuna eklenen bloklar:
  - `.hero__ek` (hero altındaki 3 şube ismi)
  - `.kareler / .kare / .kare__gorsel / .kare__etiket / .kare__ad /
    .kare__ok`
  - `.sube-detay__harita` (aspect-ratio 4/3, Leaflet konteyner ayarları,
    `img { max-width: none }` override)
  - `.harita-sekmeli` (sekmeler, çerçeve, panel, Google Maps'te aç okuyla)
  - `.genel-iletisim` (büyük tipo şerit)
  - Footer marka/slogan/moto/sosyal/iletişim/telif bağlantı stilleri
- `v-2/assets/js/harita.js` — Leaflet init:
  1) Şubeler sayfası: her `data-harita-lat/lng` divi ayrı harita.
  2) İletişim sayfası: sekmeli tek harita, marker panning + panel
     senkronu, `invalidateSize` fix.
- Header'da koşullu Leaflet CDN yüklenmesi (`$sayfa_leaflet` bayrağı).

---

## 13. İKİNCİ TUR — REVİZYONA BİREBİR HİZALAMA

Sonradan tespit edilen ve düzeltilen ince noktalar:

- **Anasayfa şube kartları revizyona uygun sadeleşti.** `sube-onizleme`
  bloğuna `varyant` alanı eklendi:
  - `varyant: 'anasayfa'` → ad + adres + tel + [Yol Tarifi] [Rezervasyon];
    Bostanlı için ek olarak **[Paket Servis]** butonu (SUBELER içindeki
    yeni `paket_servis` alanından, `/v-2/hizmetler.php#paket-servis`
    anchor'ına gider).
  - `varyant: 'iletisim'` → ad + adres + tel + **e-posta** + [Yol Tarifi]
    (revizeye birebir).
- **İletişim formu altına mini CTA eklendi:** *"Rezervasyon işlemleri için
  Rezervasyon sayfamızı kullanabilirsiniz. [Rezervasyon Yap]"*
  (`iletisim__form__rez-not` bloğu ve stili).
- **İnsan Kaynakları sayfası** oluşturuldu: `v-2/ik.php` (belge stiliyle
  taslak — neden Boğaziçi + başvuru + KVKK). Footer'daki "İnsan
  Kaynakları" bağlantısı artık `/v-2/ik.php`'ye gidiyor.
- **Kurumsal zaman çizelgesi yatay yapıldı.** `zaman-cizelgesi.php`
  partial'ına dokunmadan CSS ile:
  - Masaüstü: `grid-auto-flow: column` + bağlantı çizgisi (`::before`) +
    nokta işaretleri → **1993 ─── 2010 ─── 2017 ─── BUGÜN**.
  - 780px altı: dikey akış (sol kenar çizgisi + soldan noktalar) — okuma
    kolaylığı korunuyor.
- **Anchor destek:** `hikaye` partial'ı artık opsiyonel `id` alanını
  destekliyor; paket servis bloğunun `id="paket-servis"` olması Bostanlı
  kartındaki [Paket Servis] butonunun sorunsuz atlama yapmasını sağlıyor.
- **Bostanlı adresinde fazladan "Karşıyaka" ibaresi kaldırıldı** — revizyon
  metnine birebir uyum: "Cengiz Topel Caddesi No: 38/B, Bostanlı – İzmir".

**Sonuç:** revizeler.md'de listelenen her madde v-2'de karşılandı.
Kalan tek bakiye — müşteriden gelecek gerçek görseller (hero, şube kart
görselleri, mutfak/hijyen fotoğrafları) ve doğrulanmış lat/lng koordinatları
ile telefon/e-posta bilgileri; şu an placeholder olarak duruyor.
