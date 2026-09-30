# Backlog — v-1 revizeleri

Kaynak: `revizeler.md`. Acil iş (anasayfa hero) bitince sırayla ele alınacak.

## Anasayfa
- [x] Hero (Prompt 1)
- [x] "Yemekte Boğaziçi Dokunuşu" metni eski Mutfak bölümüne (Prompt 2)
- [ ] SORU: revizeler.md'deki "Üç farklı lokasyon, aynı Boğaziçi deneyimi." + 3 değer (Özenli Mutfak / Kaliteli Hizmet / Keyifli Atmosfer) anasayfada ayrı bölüm olarak isteniyor mu? Prompt 2'de kaldırıldı; müşteri son mesajında sadece başlık + paragraf verdi.
- [x] Şube kartları ("Size En Yakın Boğaziçi"): ad + adres + telefon + [Yol Tarifi] [Rezervasyon]; Bostanlı'ya [Paket Servis]. Saat/bölge satırları çıkacak. (Görseller Prompt 31, Yol tarifi ghost buton Prompt 30 ile yapıldı.)
- [x] "Boğaziçi'nden Kareler": 3 kare + Şubeler sayfasına anchor (Prompt 5-6). Şimdilik sube-*-ic.webp kullanılıyor; müşteri fotoğrafları gelince admin panelden değiştirilecek.
- [x] Rezervasyon CTA: "Yeriniz Hazır" + [Rezervasyon Yap] [Şubeleri Gör] (Prompt 7). Müşteri talebiyle 4 adımlı liste kaldırıldı, bölüm cta-bant'a çevrildi (Prompt 18).
- [x] Şube bölümü başlığı "Size En Yakın Boğaziçi" (Prompt 3)
- [x] Rakamlar bölümü kaldırıldı (Prompt 4)
- [x] CTA butonları eşit genişlik (Prompt 8)
- [x] SSS bölümü kaldırıldı (Prompt 9)

## Şubeler
- [x] Hero, liste başlığı, kapanış metinleri (Prompt 17). "Kalabalık grup" CTA'sı kapanışla değiştirildi.
- [x] Kartlara anchor id (Prompt 5)
- [x] Footer şube linkleri → /subeler.php#sube-{slug} (Prompt 40)
- [ ] SORU: "BUNLARI KALDIRALIM" tam olarak neyi kapsıyor? (CTA mı, bölge rozetleri/saatler mi?)

## Kurumsal / Hizmetler
- [x] Hero üstlükleri "Kurumsal"/"Hizmetler" → "Boğaziçi Restaurant" (Prompt 22)

## Tasarım düzeltmeleri (tamamlandı)
- [x] Görsel/metin dönüşüm hatası (Prompt 10)
- [x] Son koyu bölüm-footer boşluğu + CTA başlık boşluğu (Prompt 11, 11b)
- [x] İletişim şube kartları (Prompt 12)
- [x] Zaman çizelgesi yeniden tasarım (Prompt 13)
- [x] Menü ürün görselleri + lightbox + hiza hatası (Prompt 14). 9 üründe örnek görsel var, 25'i boş ikonlu; gerçek ürün fotoğrafları müşteriden gelecek.
- [ ] Genel tutarlılık denetimi (/ui-ux-pro-max ile tek sefer, revizeler bitince). Zaman çizelgesi halka rengi ham rgb → token.
- [x] Metin-görsel başlık-paragraf boşluğu 72→24px (Prompt 42)

## Menü
- [ ] 6 kategori + açıklamaları: Mezeler, Ara Sıcaklar, Balık & Deniz Ürünleri, Et & Izgara, Salatalar, Tatlılar
- [ ] SORU: satır 191 "bunu kaldıralım" neyi kastediyor? (ürün rozetleri mi?)
- [ ] SORU: Örnek ürünler yeni kategorilere dağıtılsın mı, gerçek menü mü gelecek?

## İletişim
- [x] Hero: "BOĞAZİÇİ RESTAURANT / Bizimle İletişime Geçin" + kısa alt metin (Prompt 22)

## Müşteri görselleri (tamamlandı)
- [x] Yemekte Boğaziçi Dokunuşu (P26), metin-gorsel sizes/netlik (P27), "görsel tam" seçeneği (P28, şu an kullanılmıyor)
- [x] Şube görselleri: anasayfa kartları, iletişim kartları, şube kapakları (P31)
- [x] Kurumsal: Klasiği kolajı (P32-33), Mutfak Anlayışımız (P34), Kalite & Hijyen (P35)
- [x] Hizmetler: İş Toplantıları (P36), Özel Anlar (P37), Catering (P38)
- [x] İletişim kartı butonları (P23-24), footer sadece Instagram (P25)
- [ ] Hizmetler "Paket Servis" hâlâ mutfak.webp (müşteri görsel vermedi)
- [ ] "Boğaziçi'nden Kareler" hâlâ sube-*-ic.webp yer tutucular
- [ ] Menü ürün görselleri: 9 örnek, 25 boş
- [ ] Hero görselleri (masaüstü + mobil) hâlâ eski
- [ ] SORU: İş Toplantısı ve Catering görsellerinde İstanbul silüeti/Boğaz Köprüsü var (restoran İzmir'de)
- [x] musteri-gorseller/ .gitignore'a eklendi (bilgisayarda duruyor, repoya gitmiyor)

## Admin / Yayın
- [x] Vercel demo modu (Prompt 19), sonra kalıcı depolama: Upstash Redis + Vercel Blob + çerezli giriş (Prompt 20-21)
- [ ] DİKKAT: Admin'de ilk kayıttan sonra Vercel içeriği Redis'ten okunur; repodaki veri.json değişiklikleri Vercel'e yansımaz. Metin revizeleri müşteri teste başlamadan bitmeli ya da Redis↔dosya eşitleme aracı yazılmalı.
- [x] Form: 4 alan zorunlu (*), novalidate kaldırıldı, yeni KVKK cümlesi (Prompt 40)
- [ ] Form gönderimi: /iletisim-gonder.php YOK (404). Mail gönderen dosya yazılacak. SORU: mesajlar hangi adrese gitsin?
- [x] Anasayfa şube kartları: saat/bölge çıktı, telefon, Rezervasyon + Yol tarifi (+ Bostanlı Paket servis), kart linki butonları örtme hatası (Prompt 39)

## Footer / Genel
- [x] Footer şube linkleri Şubeler sayfasındaki karta (Prompt 40)
- [x] Footer Instagram ikonu hizası 44/20px (Prompt 41)
- [x] galeri.php → 301 anasayfa, sayfalar['galeri'] veriden silindi (Prompt 42)
- [x] sube.php:35 "anında onaylansın" → teyit cümlesi (Prompt 40)
