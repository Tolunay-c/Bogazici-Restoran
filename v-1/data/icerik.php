<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   GEÇİCİ İÇERİK
   Panel şemasının birebir aynısı. Veritabanına geçildiğinde:
     $sayfalar['anasayfa']  ->  SELECT * FROM bolumler WHERE sayfa=? ORDER BY sira
     $b['ogeler']           ->  SELECT * FROM bolum_ogeleri WHERE bolum_id=? ORDER BY sira
   Başka hiçbir dosya değişmeyecek.
   -------------------------------------------------------------- */

const SUBELER = [
    [
        'slug' => 'alsancak',
        'ad' => 'Alsancak',
        'adres' => 'Alsancak Mah. Kordon Cad. No: 12, Konak / İzmir',
        'telefon' => '+902321234567',
        'telefon_yazi' => '0232 123 45 67',
        'saat' => 'Her gün 12:00 – 24:00',
        'gorsel' => 'sube-alsancak.webp',
        'enlem' => 38.4310, 'boylam' => 27.1400,   // YER TUTUCU koordinat
        'yol_tarifi' => 'https://maps.google.com/?q=Bogazici+Restaurant+Alsancak',
        'bolgeler' => ['Deniz manzaralı teras', 'İç salon', 'Bahçe'],
    ],
    [
        'slug' => 'cesme',
        'ad' => 'Çeşme',
        'adres' => 'Ilıca Mah. Sahil Cad. No: 4, Çeşme / İzmir',
        'telefon' => '+902327654321',
        'telefon_yazi' => '0232 765 43 21',
        'saat' => 'Her gün 11:00 – 01:00',
        'gorsel' => 'sube-cesme.webp',
        'enlem' => 38.3050, 'boylam' => 26.3550,   // YER TUTUCU koordinat
        'yol_tarifi' => 'https://maps.google.com/?q=Bogazici+Restaurant+Cesme',
        'bolgeler' => ['Sahil terası', 'İç salon', 'Loca'],
    ],
    [
        'slug' => 'karsiyaka',
        'ad' => 'Karşıyaka',
        'adres' => 'Bostanlı Mah. Sahil Bulvarı No: 88, Karşıyaka / İzmir',
        'telefon' => '+902329876543',
        'telefon_yazi' => '0232 987 65 43',
        'saat' => 'Her gün 12:00 – 24:00',
        'gorsel' => 'sube-karsiyaka.webp',
        'enlem' => 38.4560, 'boylam' => 27.1000,   // YER TUTUCU koordinat
        'yol_tarifi' => 'https://maps.google.com/?q=Bogazici+Restaurant+Karsiyaka',
        'bolgeler' => ['Bahçe', 'İç salon', 'Üst kat'],
    ],
];

$sayfalar = [];

$sayfalar['anasayfa'] = [
    [
        'tip' => 'hero',
        'zemin' => 'koyu',
        'ustluk' => '1998’den beri İzmir’de',
        'baslik' => 'Denizin sofraya en kısa yolu',
        'alt_baslik' => 'Günlük tezgâh, üç şube, aynı mutfak. Akşam için yeriniz hazır olsun.',
        'gorsel' => 'hero-anasayfa.webp',
        'gorsel_mobil' => 'hero-anasayfa-mobil.webp',
        'gorsel_odak' => 'merkez',
        'gorsel_alt' => 'Kordon’a bakan teras ve akşam servisi',
        'buton_yazi' => 'Rezervasyon yap',
        'buton_link' => '/rezervasyon.php',
        'buton2_yazi' => 'Menüyü incele',
        'buton2_link' => '/menu.php',
    ],
    [
        'tip' => 'metin-gorsel',
        'zemin' => 'beyaz',
        'yon' => 'sag',
        'ustluk' => 'Mutfak',
        'baslik' => 'Tezgâhta ne varsa, tabakta o var',
        'metin' => 'Balık her sabah İzmir hâlinden geliyor; menü mevsime göre değişiyor. Meze tabaklarımızın tamamı günlük hazırlanıyor, hiçbiri bir gün öncesinden kalmıyor. Şubeler arasında tarif farkı yok — Çeşme’de yediğiniz humus Karşıyaka’da da aynı.',
        'gorsel' => 'mutfak.webp',
        'gorsel_odak' => 'merkez',
        'gorsel_alt' => 'Mutfakta günlük meze hazırlığı',
        'buton_yazi' => 'Hikâyemiz',
        'buton_link' => '/kurumsal.php',
    ],
    [
        'tip' => 'menu-vitrin',
        'zemin' => 'kum',
        'ustluk' => 'Bu haftanın tezgâhı',
        'baslik' => 'Öne çıkanlar',
        'alt_baslik' => 'Fiyatlar günlük tezgâha göre değişebilir.',
        'buton_yazi' => 'Menünün tamamı',
        'buton_link' => '/menu.php',
        'ogeler' => [
            ['baslik' => 'Çupra ızgara', 'metin' => 'Porsiyon, mevsim yeşilliği ile', 'fiyat' => '780 ₺', 'gorsel' => 'urun-cupra.webp'],
            ['baslik' => 'Ahtapot ızgara', 'metin' => 'Közlenmiş patates, limon', 'fiyat' => '920 ₺', 'gorsel' => 'urun-ahtapot.webp'],
            ['baslik' => 'Karides güveç', 'metin' => 'Kaşarlı, fırında', 'fiyat' => '640 ₺', 'gorsel' => 'urun-karides.webp'],
            ['baslik' => 'Meze tabağı', 'metin' => 'Yedi çeşit, iki kişilik', 'fiyat' => '540 ₺', 'gorsel' => 'urun-meze.webp'],
        ],
    ],
    [
        'tip' => 'sube-listesi',
        'zemin' => 'beyaz',
        'ustluk' => 'Şubeler',
        'baslik' => 'Üç sahil, tek mutfak',
        'alt_baslik' => 'Rezervasyon sırasında şubeyi ve oturmak istediğiniz bölgeyi siz seçiyorsunuz.',
    ],
    [
        'tip' => 'rakamlar',
        'zemin' => 'kum',
        'ustluk' => 'Kısaca',
        'baslik' => 'Boğaziçi rakamlarla',
        'alt_baslik' => 'Yirmi yedi yıldır aynı tezgâh anlayışı, üç ayrı sahilde.',
        'gorsel' => 'rakamlar.webp',
        'gorsel_odak' => 'merkez',
        'gorsel_alt' => 'Tezgâhta günlük balık seçimi',
        'ogeler' => [
            ['sayi' => '1998', 'etiket' => 'Kuruluş yılı'],
            ['sayi' => '3', 'etiket' => 'Şube'],
            ['sayi' => '40+', 'etiket' => 'Meze çeşidi'],
            ['sayi' => '260', 'etiket' => 'Kişilik toplam kapasite'],
        ],
    ],
    [
        'tip' => 'galeri-onizleme',
        'zemin' => 'beyaz',
        'ustluk' => 'Galeri',
        'baslik' => 'Mekândan kareler',
        'kirp' => true,          // önizlemede alt kenar düz kesilir
        'buton_yazi' => 'Tüm galeri',
        'buton_link' => '/galeri.php',
        'ogeler' => [
            // en/boy panelde yükleme anında kaydedilir; masonry oranı
            // görsel inmeden bilmek zorunda, yoksa yerleşim zıplar.
            ['gorsel' => 'galeri-01.webp', 'gorsel_alt' => 'Galeri 1', 'en' => 960, 'boy' => 1280],
            ['gorsel' => 'galeri-02.webp', 'gorsel_alt' => 'Galeri 2', 'en' => 960, 'boy' => 720],
            ['gorsel' => 'galeri-03.webp', 'gorsel_alt' => 'Galeri 3', 'en' => 960, 'boy' => 1440],
            ['gorsel' => 'galeri-04.webp', 'gorsel_alt' => 'Galeri 4', 'en' => 960, 'boy' => 960],
            ['gorsel' => 'galeri-05.webp', 'gorsel_alt' => 'Galeri 5', 'en' => 960, 'boy' => 640],
            ['gorsel' => 'galeri-06.webp', 'gorsel_alt' => 'Galeri 6', 'en' => 960, 'boy' => 1200],
            ['gorsel' => 'galeri-07.webp', 'gorsel_alt' => 'Galeri 7', 'en' => 960, 'boy' => 1280],
            ['gorsel' => 'galeri-08.webp', 'gorsel_alt' => 'Galeri 8', 'en' => 960, 'boy' => 960],
            ['gorsel' => 'galeri-09.webp', 'gorsel_alt' => 'Galeri 9', 'en' => 960, 'boy' => 720],
            ['gorsel' => 'galeri-10.webp', 'gorsel_alt' => 'Galeri 10', 'en' => 960, 'boy' => 1440],
            ['gorsel' => 'galeri-11.webp', 'gorsel_alt' => 'Galeri 11', 'en' => 960, 'boy' => 1280],
            ['gorsel' => 'galeri-12.webp', 'gorsel_alt' => 'Galeri 12', 'en' => 960, 'boy' => 540],
            ['gorsel' => 'galeri-13.webp', 'gorsel_alt' => 'Galeri 13', 'en' => 960, 'boy' => 960],
            ['gorsel' => 'galeri-14.webp', 'gorsel_alt' => 'Galeri 14', 'en' => 960, 'boy' => 1200],
            ['gorsel' => 'galeri-15.webp', 'gorsel_alt' => 'Galeri 15', 'en' => 960, 'boy' => 640],
            ['gorsel' => 'galeri-16.webp', 'gorsel_alt' => 'Galeri 16', 'en' => 960, 'boy' => 1280],
            ['gorsel' => 'galeri-17.webp', 'gorsel_alt' => 'Galeri 17', 'en' => 960, 'boy' => 960],
            ['gorsel' => 'galeri-18.webp', 'gorsel_alt' => 'Galeri 18', 'en' => 960, 'boy' => 720],
        ],
    ],
    [
        'tip' => 'rezervasyon-blok',
        'zemin' => 'koyu',
        'ustluk' => 'Rezervasyon',
        'baslik' => 'Masanız birkaç adımda hazır',
        'metin' => 'Şube ve bölgeyi seçin, saatinizi belirleyin. Rezervasyonunuz anında onaylanır, SMS ile teyit gelir.',
        'buton_yazi' => 'Rezervasyona başla',
        'buton_link' => '/rezervasyon.php',
        'on_secili_sube' => '',
    ],
    [
        'tip' => 'sss',
        'zemin' => 'beyaz',
        'ustluk' => 'Sık sorulanlar',
        'baslik' => 'Gelmeden önce',
        'ogeler' => [
            ['baslik' => 'Rezervasyon ücretli mi?', 'metin' => 'Hayır. Rezervasyon için ön ödeme veya kart bilgisi istemiyoruz.'],
            ['baslik' => 'Kaç kişiye kadar rezervasyon yapabilirim?', 'metin' => 'Siteden 12 kişiye kadar rezervasyon yapılabilir. Daha kalabalık gruplar için şubeyi arayın.'],
            ['baslik' => 'Bölge seçimim garanti mi?', 'metin' => 'Seçtiğiniz bölge sizin adınıza ayrılır. Belirli bir masa talebiniz varsa rezervasyon notuna yazabilirsiniz.'],
            ['baslik' => 'Paket servis var mı?', 'metin' => 'Üç şubede de paket servis mevcut. Menüde paket servise uygun ürünler ayrıca işaretlidir.'],
        ],
    ],
];

$sayfalar['kurumsal'] = [
    [
        'tip' => 'sayfa-basligi',
        'zemin' => 'koyu',
        'ustluk' => 'Kurumsal',
        'baslik' => 'Bir tezgâhla başladı',
        'gorsel' => 'basluk-kurumsal.webp',
        'gorsel_odak' => 'ust',
        'gorsel_alt' => '',
    ],
    [
        'tip' => 'metin-gorsel',
        'zemin' => 'beyaz',
        'yon' => 'sag',
        'baslik' => '1998’den bugüne',
        'metin' => 'Alsancak’ta on iki masalık bir balıkçı olarak açıldık. Bugün üç şubede hizmet veriyoruz; mutfak ekibinin çekirdek kadrosu ilk günden beri aynı.',
        'gorsel' => 'kurumsal-01.webp',
        'gorsel_alt' => 'İlk şubenin arşiv fotoğrafı',
    ],
    [
        'tip' => 'kart-izgara',
        'zemin' => 'kum',
        'ustluk' => 'Çalışma biçimimiz',
        'baslik' => 'Değişmeyen üç şey',
        'ogeler' => [
            ['baslik' => 'Günlük tedarik', 'metin' => 'Balık ve sebze her sabah alınır; dondurulmuş ürün kullanılmaz.'],
            ['baslik' => 'Tek tarif defteri', 'metin' => 'Üç şubede aynı ölçüler, aynı sunum.'],
            ['baslik' => 'Sabit ekip', 'metin' => 'Mutfak şefleri ve servis sorumluları uzun yıllardır bizimle.'],
        ],
    ],
    [
        'tip' => 'cta-bant',
        'zemin' => 'koyu',
        'baslik' => 'Özel gününüz için ayrı planlama yapıyoruz',
        'metin' => 'Nişan, doğum günü ve kurumsal yemekler için şube sorumlusuyla görüşün.',
        'buton_yazi' => 'İletişime geçin',
        'buton_link' => '/iletisim.php',
    ],
];

/* -------------------- Şubeler -------------------- */
$sayfalar['subeler'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Şubeler',
     'baslik' => 'Üç sahil, tek mutfak', 'gorsel' => 'basluk-subeler.webp', 'gorsel_odak' => 'merkez', 'gorsel_alt' => ''],
    ['tip' => 'sube-listesi', 'zemin' => 'beyaz', 'duzen' => 'yatay',
     'baslik' => 'Nerede buluşalım?',
     'alt_baslik' => 'Her şubede aynı menü ve aynı mutfak ekibi. Fark yalnızca manzarada.'],
    ['tip' => 'cta-bant', 'zemin' => 'koyu',
     'baslik' => 'Kalabalık grup mu geliyor?',
     'metin' => '12 kişiden büyük gruplar için şube sorumlusuyla doğrudan görüşün.',
     'buton_yazi' => 'İletişim', 'buton_link' => '/iletisim.php'],
];

/* -------------------- Hizmetler -------------------- */
$sayfalar['hizmetler'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Hizmetler',
     'baslik' => 'Sofranızı biz kuralım', 'gorsel' => 'basluk-hizmetler.webp', 'gorsel_alt' => ''],
    ['tip' => 'kart-izgara', 'zemin' => 'beyaz',
     'ustluk' => 'Ne yapıyoruz', 'baslik' => 'Üç ayrı hizmet',
     'alt_baslik' => 'Restoran dışında da çalışıyoruz.',
     'ogeler' => [
        ['baslik' => 'Özel gün organizasyonu', 'metin' => 'Nişan, doğum günü ve yıldönümleri için ayrı menü ve yerleşim planı.', 'gorsel' => 'hizmet-01.webp', 'gorsel_alt' => ''],
        ['baslik' => 'Kurumsal yemek', 'metin' => 'Toplantı ve ekip yemekleri; sabit menü, fatura ve önceden yerleşim.', 'gorsel' => 'hizmet-02.webp', 'gorsel_alt' => ''],
        ['baslik' => 'Paket servis', 'metin' => 'Meze ve ızgara seçkisi; üç şubeden de aynı gün teslim.', 'gorsel' => 'hizmet-03.webp', 'gorsel_alt' => ''],
     ]],
    ['tip' => 'metin-gorsel', 'zemin' => 'kum', 'yon' => 'sol',
     'ustluk' => 'Nasıl ilerliyor', 'baslik' => 'Önce konuşuyoruz, sonra menü yazıyoruz',
     'metin' => 'Kişi sayısı, bütçe ve tercihleri konuşuyoruz; şube sorumlusu size özel bir menü önerisi hazırlıyor. Onaydan sonra yerleşim planını birlikte çıkarıyoruz.',
     'gorsel' => 'kurumsal-01.webp', 'gorsel_alt' => '',
     'buton_yazi' => 'Teklif isteyin', 'buton_link' => '/iletisim.php'],
];

/* -------------------- Menü -------------------- */
$menu_kategorileri = [
    ['ad' => 'Soğuk mezeler', 'urunler' => [
        ['ad' => 'Humus', 'aciklama' => 'Tahin, limon, zeytinyağı', 'fiyat' => '210 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Deniz börülcesi', 'aciklama' => 'Sarımsaklı zeytinyağı ile', 'fiyat' => '190 ₺', 'etiketler' => ['Vejetaryen']],
        ['ad' => 'Ahtapot salatası', 'aciklama' => 'Kırmızı soğan, dereotu', 'fiyat' => '340 ₺', 'etiketler' => []],
        ['ad' => 'Meze tabağı', 'aciklama' => 'Yedi çeşit, iki kişilik', 'fiyat' => '540 ₺', 'etiketler' => ['Paket servis']],
    ]],
    ['ad' => 'Ara sıcaklar', 'urunler' => [
        ['ad' => 'Karides güveç', 'aciklama' => 'Kaşarlı, fırında', 'fiyat' => '640 ₺', 'etiketler' => ['Paket servis']],
        ['ad' => 'Kalamar tava', 'aciklama' => 'Tartar sos ile', 'fiyat' => '480 ₺', 'etiketler' => []],
        ['ad' => 'Sigara böreği', 'aciklama' => 'Beyaz peynir, maydanoz', 'fiyat' => '240 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
    ]],
    ['ad' => 'Ana yemekler', 'urunler' => [
        ['ad' => 'Çupra ızgara', 'aciklama' => 'Porsiyon, mevsim yeşilliği ile', 'fiyat' => '780 ₺', 'etiketler' => []],
        ['ad' => 'Levrek ızgara', 'aciklama' => 'Porsiyon, limon sos', 'fiyat' => '760 ₺', 'etiketler' => []],
        ['ad' => 'Ahtapot ızgara', 'aciklama' => 'Közlenmiş patates, limon', 'fiyat' => '920 ₺', 'etiketler' => ['Paket servis']],
    ]],
    ['ad' => 'Tatlılar', 'urunler' => [
        ['ad' => 'İrmik helvası', 'aciklama' => 'Dondurma ile', 'fiyat' => '180 ₺', 'etiketler' => ['Vejetaryen']],
        ['ad' => 'Kabak tatlısı', 'aciklama' => 'Tahin, ceviz', 'fiyat' => '170 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
    ]],
];

$sayfalar['menu'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Menü',
     'baslik' => 'Bugün tezgâhta ne var?', 'gorsel' => 'basluk-menu.webp', 'gorsel_alt' => ''],
    ['tip' => 'menu-liste', 'zemin' => 'beyaz',
     'alt_baslik' => 'Fiyatlar günlük tezgâha göre değişebilir. Paket servise uygun ürünler ayrıca işaretlidir.',
     'kategoriler' => $menu_kategorileri],
    ['tip' => 'cta-bant', 'zemin' => 'kum',
     'baslik' => 'Masanızı ayırtın', 'metin' => 'Menüyü beğendiyseniz gerisi kolay.',
     'buton_yazi' => 'Rezervasyon yap', 'buton_link' => '/rezervasyon.php'],
];

/* -------------------- Galeri -------------------- */
$sayfalar['galeri'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Galeri',
     'baslik' => 'Mekândan kareler', 'gorsel' => 'basluk-galeri.webp', 'gorsel_alt' => ''],
    ['tip' => 'galeri-onizleme', 'zemin' => 'beyaz',
     'ogeler' => $sayfalar['anasayfa'][5]['ogeler']],
];

/* -------------------- İletişim -------------------- */
$sayfalar['iletisim'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'İletişim',
     'baslik' => 'Bize ulaşın', 'gorsel' => 'basluk-iletisim.webp', 'gorsel_alt' => ''],
    ['tip' => 'iletisim', 'zemin' => 'beyaz',
     'ustluk' => 'Yazın', 'baslik' => 'Sorunuz mu var?',
     'metin' => 'Rezervasyon için formu değil, rezervasyon sayfasını kullanın — orada anında onay alıyorsunuz.'],
];
