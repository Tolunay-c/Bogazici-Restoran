# Backlog — v-1 revizeleri

Kaynak: `revizeler.md`. Acil iş (anasayfa hero) bitince sırayla ele alınacak.

## Anasayfa
- [x] Hero (Prompt 1)
- [x] "Yemekte Boğaziçi Dokunuşu" metni eski Mutfak bölümüne (Prompt 2)
- [ ] SORU: revizeler.md'deki "Üç farklı lokasyon, aynı Boğaziçi deneyimi." + 3 değer (Özenli Mutfak / Kaliteli Hizmet / Keyifli Atmosfer) anasayfada ayrı bölüm olarak isteniyor mu? Prompt 2'de kaldırıldı; müşteri son mesajında sadece başlık + paragraf verdi.
- [ ] Şube kartları ("Size En Yakın Boğaziçi"): ad + adres + telefon + [Yol Tarifi] [Rezervasyon]; Bostanlı'ya [Paket Servis]. Saat/bölge satırları çıkacak. Görseller müşteriden gelecek.
- [x] "Boğaziçi'nden Kareler": 3 kare + Şubeler sayfasına anchor (Prompt 5-6). Şimdilik sube-*-ic.webp kullanılıyor; müşteri fotoğrafları gelince admin panelden değiştirilecek.
- [x] Rezervasyon CTA: "Yeriniz Hazır" + [Rezervasyon Yap] [Şubeleri Gör] (Prompt 7). 4 adımlı liste korundu.
- [x] Şube bölümü başlığı "Size En Yakın Boğaziçi" (Prompt 3)
- [x] Rakamlar bölümü kaldırıldı (Prompt 4)
- [x] CTA butonları eşit genişlik (Prompt 8)
- [x] SSS bölümü kaldırıldı (Prompt 9)

## Şubeler
- [x] Hero, liste başlığı, kapanış metinleri (Prompt 17). "Kalabalık grup" CTA'sı kapanışla değiştirildi.
- [x] Kartlara anchor id (Prompt 5)
- [ ] Footer şube linkleri hâlâ sube.php?s= → /subeler.php#sube-{slug} yapılacak
- [ ] SORU: "BUNLARI KALDIRALIM" tam olarak neyi kapsıyor? (CTA mı, bölge rozetleri/saatler mi?)

## Kurumsal / Hizmetler
- [ ] Hero üstlükleri "Kurumsal"/"Hizmetler" → "Boğaziçi Restaurant"

## Tasarım düzeltmeleri (tamamlandı)
- [x] Görsel/metin dönüşüm hatası (Prompt 10)
- [x] Son koyu bölüm-footer boşluğu + CTA başlık boşluğu (Prompt 11, 11b)
- [x] İletişim şube kartları (Prompt 12)
- [x] Zaman çizelgesi yeniden tasarım (Prompt 13)
- [x] Menü ürün görselleri + lightbox + hiza hatası (Prompt 14). 9 üründe örnek görsel var, 25'i boş ikonlu; gerçek ürün fotoğrafları müşteriden gelecek.
- [ ] Genel tutarlılık denetimi (/ui-ux-pro-max ile tek sefer, revizeler bitince). Zaman çizelgesi halka rengi ham rgb → token.
- [ ] Metin-görsel bölümlerinde başlık ile paragraf arası boşluk fazla

## Menü
- [ ] 6 kategori + açıklamaları: Mezeler, Ara Sıcaklar, Balık & Deniz Ürünleri, Et & Izgara, Salatalar, Tatlılar
- [ ] SORU: satır 191 "bunu kaldıralım" neyi kastediyor? (ürün rozetleri mi?)
- [ ] SORU: Örnek ürünler yeni kategorilere dağıtılsın mı, gerçek menü mü gelecek?

## İletişim
- [ ] Hero: "BOĞAZİÇİ RESTAURANT / Bizimle İletişime Geçin" + kısa alt metin
- [ ] Form: 4 alan da zorunlu (*), KVKK cümlesi "KVKK Aydınlatma Metni'ni okudum ve kabul ediyorum."

## Footer / Genel
- [ ] Footer şube linkleri `sube.php?s=` yerine Şubeler sayfasındaki ilgili karta
- [ ] `galeri.php` kapatılsın/yönlendirilsin, admin listesinden çıkarılsın
- [ ] `sube.php:35` "anında onaylansın" ifadesi değişecek
