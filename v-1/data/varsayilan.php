<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   Varsayılan içerik — veri.json yoksa bu döner.
   Admin paneli düzenlemelerini veri.json'a yazar; bu dosya
   fabrika ayarları / reset kaynağıdır.
   -------------------------------------------------------------- */

$varsayilan = [
    'subeler' => [
        [
            'slug' => 'uckuyular',
            'ad' => 'Üçkuyular',
            'adres' => 'Bahçeler Arası Mah. Haydar Aliyev Bulvarı No: 2/A, Balçova / İzmir',
            'telefon' => '+908508500850',
            'telefon_yazi' => '0850 850 0850',
            'eposta' => 'uckuyular@bogazicirestaurant.com.tr',
            'saat' => 'Her gün 12:00 – 24:00',
            'gorsel' => 'sube-uckuyular.jpg',
            'enlem' => 38.3873, 'boylam' => 27.0399,
            'yol_tarifi' => 'https://www.google.com/maps/search/?api=1&query=Bogazici+Restaurant+Uckuyular+Balcova',
            'bolgeler' => ['Deniz manzaralı teras', 'İç salon', 'Bahçe'],
            'not' => 'Kahvaltı Servisi Mevcuttur',
        ],
        [
            'slug' => 'narlidere',
            'ad' => 'Narlıdere',
            'adres' => 'Limanreis Mah. Mithatpaşa Cd. No: 606, 35320 Narlıdere / İzmir',
            'telefon' => '+908508500850',
            'telefon_yazi' => '0850 850 0850',
            'eposta' => 'narlidere@bogazicirestaurant.com.tr',
            'saat' => 'Her gün 11:00 – 01:00',
            'gorsel' => 'sube-narlidere.jpg',
            'enlem' => 38.3925, 'boylam' => 27.0060,
            'yol_tarifi' => 'https://www.google.com/maps/search/?api=1&query=Bogazici+Restaurant+Narlidere',
            'bolgeler' => ['Sahil terası', 'İç salon', 'Loca'],
            'not' => 'Kahvaltı Servisi Mevcuttur',
        ],
        [
            'slug' => 'bostanli',
            'ad' => 'Bostanlı',
            'adres' => 'Cengiz Topel Caddesi No: 38/B, Bostanlı – İzmir',
            'telefon' => '+908508500850',
            'telefon_yazi' => '0850 850 0850',
            'eposta' => 'bostanli@bogazicirestaurant.com.tr',
            'saat' => 'Her gün 12:00 – 24:00',
            'gorsel' => 'sube-bostanli.jpg',
            'enlem' => 38.4664, 'boylam' => 27.0975,
            'yol_tarifi' => 'https://www.google.com/maps/search/?api=1&query=Bogazici+Restaurant+Bostanli+Izmir',
            'bolgeler' => ['Bahçe', 'İç salon', 'Üst kat'],
            'not' => 'Kahvaltı Servisi Mevcuttur',
            'paket_servis' => '/hizmetler.php#paket-servis',
        ],
    ],
    'sayfalar' => [],
];

// Galeri sayfası kendi kopyasını kullanır; anasayfadan bağımsızdır.
$galeri_ogeleri = [
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
];

$varsayilan['sayfalar']['anasayfa'] = [
    [
        'tip' => 'hero', 'zemin' => 'koyu',
        'ustluk' => 'Boğaziçi Restaurant',
        'baslik' => 'İzmir’de Lezzetin Buluşma Noktası',
        'alt_baslik' => 'Üç şubemizde, özenle hazırlanan sofraları kaliteli hizmet ve Boğaziçi deneyimiyle buluşturuyoruz.',
        'gorsel' => 'hero-anasayfa.webp',
        'gorsel_mobil' => 'hero-anasayfa-mobil.webp',
        'gorsel_odak' => 'merkez',
        'gorsel_alt' => 'Kordon’a bakan teras ve akşam servisi',
        'buton_yazi' => 'Şubelerimizi Keşfedin', 'buton_link' => '/subeler.php',
        'buton2_yazi' => 'Rezervasyon', 'buton2_link' => '/rezervasyon.php',
        'alt_not' => 'Üçkuyular • Narlıdere • Bostanlı',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
        'baslik' => 'Yemekte Boğaziçi Dokunuşu',
        'metin' => 'İyi bir yemeğin yalnızca lezzetten ibaret olmadığına inanıyoruz. Özenli sunum, kaliteli ürünler ve güçlü hizmet anlayışımızla her buluşmayı keyifli bir deneyime dönüştürüyoruz.',
        'gorsel' => 'yemekte-bogazici-dokunusu.jpg', 'gorsel_odak' => 'merkez',
        'gorsel_alt' => 'Boğaziçi Restaurant salonu, deniz manzaralı masalar',
        'buton_yazi' => 'Hikâyemiz', 'buton_link' => '/kurumsal.php',
    ],
    [
        'tip' => 'sube-listesi', 'zemin' => 'beyaz',
        'ustluk' => 'Şubeler', 'baslik' => 'Size En Yakın Boğaziçi',
        'alt_baslik' => 'İzmir’in üç farklı noktasında aynı lezzet ve hizmet anlayışı.',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sol',
        'baslik' => 'Güne Boğaziçi ile Başlayın',
        'metin' => 'Özenle hazırlanan kahvaltılıklar, sıcak lezzetler ve sofranın vazgeçilmezleriyle güne keyifli bir başlangıç yapın. Kahvaltımız üç şubemizde de sizi bekliyor.',
        'gorsel' => 'anasayfa-kahvalti.jpg', 'gorsel_odak' => 'merkez',
        'gorsel_alt' => 'Peynir, reçel, zeytin ve sıcaklarla kurulmuş Boğaziçi kahvaltı sofrası',
        'buton_yazi' => 'Menüyü İncele', 'buton_link' => '/menu.php',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
        'baslik' => 'Her Sofraya Bir Boğaziçi Klasiği',
        'metin' => 'Geleneksel tatlardan özenle hazırlanan özel lezzetlere uzanan menümüzle, günün her anına eşlik eden zengin bir sofra sunuyoruz.',
        'gorsel' => 'anasayfa-her-sofraya.jpg', 'gorsel_odak' => 'merkez',
        'gorsel_alt' => 'Mezeler, balık ve salatalarla kurulmuş Boğaziçi sofrası',
        'buton_yazi' => 'Menüyü İncele', 'buton_link' => '/menu.php',
    ],
    [
        'tip' => 'kart-izgara', 'zemin' => 'beyaz',
        'baslik' => 'Boğaziçi’nden Kareler',
        'alt_baslik' => 'Üç farklı lokasyon, aynı Boğaziçi atmosferi.',
        'ogeler' => [
            ['baslik' => 'Üçkuyular', 'gorsel' => 'sube-uckuyular.jpg', 'gorsel_alt' => 'Boğaziçi Üçkuyular şubesinden bir kare', 'link' => '/subeler.php#sube-uckuyular'],
            ['baslik' => 'Narlıdere', 'gorsel' => 'sube-narlidere.jpg', 'gorsel_alt' => 'Boğaziçi Narlıdere şubesinden bir kare', 'link' => '/subeler.php#sube-narlidere'],
            ['baslik' => 'Bostanlı',  'gorsel' => 'sube-bostanli.jpg',  'gorsel_alt' => 'Boğaziçi Bostanlı şubesinden bir kare',  'link' => '/subeler.php#sube-bostanli'],
        ],
    ],
    [
        'tip' => 'cta-bant', 'zemin' => 'koyu',
        'ustluk' => 'Rezervasyon', 'baslik' => 'Yeriniz Hazır',
        'metin' => 'Boğaziçi deneyimini Üçkuyular, Narlıdere veya Bostanlı şubemizde yaşayın.',
        'buton_yazi' => 'Rezervasyon Yap', 'buton_link' => '/rezervasyon.php',
        'buton2_yazi' => 'Şubeleri Gör', 'buton2_link' => '/subeler.php',
    ],
];

$varsayilan['sayfalar']['kurumsal'] = [
    [
        'tip' => 'sayfa-basligi', 'zemin' => 'koyu',
        'ustluk' => 'Boğaziçi Restaurant', 'baslik' => '1993’ten Bugüne, Aynı Özenle',
        'alt_baslik' => 'İzmir’de başlayan Boğaziçi yolculuğu, bugün Bostanlı, Üçkuyular ve Narlıdere’de aynı kalite ve hizmet anlayışıyla devam ediyor.',
        'gorsel' => 'basluk-kurumsal.webp', 'gorsel_odak' => 'ust', 'gorsel_alt' => '',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
        'ustluk' => 'Hikâyemiz', 'baslik' => 'İzmir’de Bir Boğaziçi Klasiği',
        'metin' => "Boğaziçi Restaurant’ın yolculuğu 1993 yılında Bostanlı’da başladı. 2010 yılında Üçkuyular, 2017 yılında ise Narlıdere şubesinin katılmasıyla Boğaziçi lezzetleri İzmir Körfezi’nin farklı noktalarında misafirleriyle buluşmaya devam etti.\nYıllar içinde değişen ve gelişen menümüzü; kaliteli ürün, özenli hazırlık ve misafir memnuniyetini merkeze alan hizmet anlayışımızla bir araya getiriyoruz.\nBugün üç şubemizde, yılların deneyimini her sofraya aynı özenle taşıyoruz.",
        'gorsel' => 'kurumsal-bogazici-klasigi.jpg',
        'gorsel_alt' => 'Boğaziçi Restaurant Üçkuyular, Bostanlı ve Narlıdere şubelerinden kareler',
    ],
    [
        'tip' => 'zaman-cizelgesi', 'zemin' => 'kum',
        'baslik' => '30 Yılı Aşan Bir Hikâye',
        'ogeler' => [
            ['yil' => '1993', 'baslik' => 'Bostanlı', 'metin' => 'Boğaziçi Restaurant’ın İzmir’deki yolculuğu başladı.'],
            ['yil' => '2010', 'baslik' => 'Üçkuyular', 'metin' => 'Boğaziçi deneyimi Körfez’in diğer yakasına taşındı.'],
            ['yil' => '2017', 'baslik' => 'Narlıdere', 'metin' => 'Üçüncü şubemizle İzmir’deki hizmet ağımız genişledi.'],
            ['yil' => 'Bugün', 'baslik' => 'Üç Şube, Tek Boğaziçi', 'metin' => 'Bostanlı, Üçkuyular ve Narlıdere’de aynı hizmet anlayışıyla misafirlerimizi ağırlamaya devam ediyoruz.'],
        ],
    ],
    [
        'tip' => 'kart-izgara', 'zemin' => 'beyaz',
        'ustluk' => 'Çalışma biçimimiz', 'baslik' => 'Boğaziçi’nin Değişmeyen Değerleri',
        'ogeler' => [
            ['baslik' => 'Kalite', 'metin' => 'Ürün seçiminden sunuma kadar her aşamada kaliteyi ön planda tutuyoruz.'],
            ['baslik' => 'Özen', 'metin' => 'Her tabağı, her sofrayı ve her misafirimizi Boğaziçi deneyiminin bir parçası olarak görüyoruz.'],
            ['baslik' => 'Misafirperverlik', 'metin' => 'Yılların deneyimini güler yüzlü ve özenli hizmet anlayışıyla buluşturuyoruz.'],
        ],
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'kum', 'yon' => 'sol',
        'ustluk' => 'Mutfak Anlayışımız', 'baslik' => 'Lezzetin Temelinde Kalite Var',
        'metin' => 'Mevsiminde balık çeşitlerinden yöresel kebaplara, Ege mutfağının zeytinyağlılarından sıcak ve soğuk mezelere uzanan zengin mutfağımızda, ürün kalitesini ve tazeliği ön planda tutuyoruz.',
        'alinti' => '“İyi Ye, İyi Yaşa”',
        'gorsel' => 'kurumsal-mutfak-anlayisimiz.jpg', 'gorsel_odak' => 'alt',
        'gorsel_alt' => 'Mutfakta özenle hazırlanan bir tabak',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
        'ustluk' => 'Kalite & Hijyen', 'baslik' => 'Kalite, Boğaziçi’nin Temelidir',
        'metin' => 'Sağlıklı ürün, hijyen ve kaliteli hizmet anlayışını mutfağımızın temel standartları arasında görüyoruz. Et ve balık hazırlama süreçlerinin ayrı mutfaklarda yürütülmesi dahil olmak üzere, mutfak organizasyonumuzu kalite ve hijyen anlayışımız doğrultusunda sürdürüyoruz.',
        'gorsel' => 'kurumsal-kalite-hijyen.jpg', 'gorsel_alt' => 'Mutfakta kesme tahtasında hazırlanan taze balıklar',
    ],
    [
        'tip' => 'cta-bant', 'zemin' => 'koyu',
        'baslik' => 'Boğaziçi Deneyimini Keşfedin',
        'metin' => 'Bostanlı, Üçkuyular ve Narlıdere şubelerimizde sizi aynı özen ve misafirperverlikle karşılıyoruz.',
        'buton_yazi' => 'Şubelerimiz', 'buton_link' => '/subeler.php',
        'buton2_yazi' => 'Rezervasyon', 'buton2_link' => '/rezervasyon.php',
    ],
];

$varsayilan['sayfalar']['subeler'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Boğaziçi Restaurant',
     'baslik' => 'Üç Şube, Tek Boğaziçi Deneyimi',
     'alt_baslik' => 'İzmir’in üç farklı noktasında, aynı özenli hizmet anlayışı ve Boğaziçi lezzetleriyle sizi ağırlıyoruz.',
     'gorsel' => 'basluk-subeler.webp', 'gorsel_odak' => 'merkez', 'gorsel_alt' => ''],
    ['tip' => 'sube-listesi', 'zemin' => 'beyaz', 'duzen' => 'yatay',
     'baslik' => 'Boğaziçi’nde Buluşalım',
     'alt_baslik' => 'Size en yakın Boğaziçi şubesini seçin, sofranızı ayırtın.'],
    ['tip' => 'cta-bant', 'zemin' => 'koyu',
     'baslik' => 'Üç Farklı Lokasyon, Aynı Boğaziçi',
     'metin' => 'İzmir’in üç farklı noktasında, aynı özen ve hizmet anlayışıyla sizi ağırlıyoruz.',
     'buton_yazi' => 'Rezervasyon Yap', 'buton_link' => '/rezervasyon.php'],
];

$varsayilan['sayfalar']['hizmetler'] = [
    [
        'tip' => 'sayfa-basligi', 'zemin' => 'koyu',
        'ustluk' => 'Boğaziçi Restaurant', 'baslik' => 'Her Buluşmaya Boğaziçi Dokunuşu',
        'alt_baslik' => 'İş dünyasından özel davetlere, farklı ihtiyaçlara özenli mutfak ve profesyonel hizmet anlayışımızla eşlik ediyoruz.',
        'gorsel' => 'basluk-hizmetler.webp', 'gorsel_alt' => '',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
        'ustluk' => '01 — İş Toplantıları & Seminerler', 'baslik' => 'İş Buluşmalarınıza Özenli Bir Ev Sahipliği',
        'metin' => 'İş yemekleri, kurumsal buluşmalar, toplantılar ve seminerler için Boğaziçi’nin hizmet anlayışını profesyonel organizasyon deneyimiyle bir araya getiriyoruz.',
        'buton_yazi' => 'Bilgi al', 'buton_link' => '/iletisim.php',
        'gorsel' => 'hizmet-is-toplantisi.jpg', 'gorsel_alt' => 'Deniz manzaralı salonda iş yemeği',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'kum', 'yon' => 'sol',
        'ustluk' => '02 — Kokteyl & Etkinlik', 'baslik' => 'Özel Anlara Özenli Dokunuşlar',
        'metin' => 'Kurumsal etkinliklerden özel davetlere, farklı organizasyon ihtiyaçlarını Boğaziçi mutfağı ve hizmet kalitesiyle buluşturuyoruz.',
        'buton_yazi' => 'Organizasyon bilgisi al', 'buton_link' => '/iletisim.php',
        'gorsel' => 'hizmet-ozel-anlar.jpg', 'gorsel_alt' => 'Gün batımında deniz manzaralı davet masası',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'beyaz', 'yon' => 'sag',
        'ustluk' => '03 — Catering', 'baslik' => 'Boğaziçi Lezzetleri Dilediğiniz Yerde',
        'metin' => 'Toplantı, davet ve özel organizasyonlarınız için Boğaziçi mutfağının deneyimini bulunduğunuz mekâna taşıyoruz.',
        'buton_yazi' => 'Catering için bilgi al', 'buton_link' => '/iletisim.php',
        'gorsel' => 'hizmet-catering.jpg', 'gorsel_alt' => 'Deniz kenarında kurulmuş catering büfesi',
    ],
    [
        'tip' => 'metin-gorsel', 'zemin' => 'kum', 'yon' => 'sol', 'kimlik' => 'paket-servis',
        'ustluk' => '04 — Paket Servis', 'baslik' => 'Boğaziçi Lezzetleri Size Gelsin',
        'metin' => 'Sevdiğiniz Boğaziçi lezzetlerini restoran deneyiminden ödün vermeden, özenli hazırlık ve paketleme anlayışıyla sofranıza ulaştırıyoruz.',
        'buton_yazi' => 'Paket servis bilgi al', 'buton_link' => '/iletisim.php',
        'gorsel' => 'hizmet-paket-servis.jpg', 'gorsel_odak' => 'sol',
        'gorsel_alt' => 'Boğaziçi logolu paket servis çantası ve yemek kapları',
    ],
    [
        'tip' => 'cta-bant', 'zemin' => 'koyu',
        'baslik' => 'İhtiyacınıza Özel Çözümler',
        'metin' => 'Organizasyon, catering ve diğer hizmetlerimiz hakkında detaylı bilgi almak için ekibimizle iletişime geçebilirsiniz.',
        'buton_yazi' => 'Bilgi alın', 'buton_link' => '/iletisim.php',
        'buton2_yazi' => 'İletişim', 'buton2_link' => '/iletisim.php',
    ],
];

$menu_kategorileri = [
    ['ad' => 'Başlangıçlar', 'urunler' => [
        ['ad' => 'Mercimek çorbası', 'aciklama' => 'Limon, tereyağı',            'fiyat' => '120 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Balık çorbası',    'aciklama' => 'Günün taze balığından',       'fiyat' => '260 ₺', 'etiketler' => []],
        ['ad' => 'Yaprak sarma',     'aciklama' => 'Zeytinyağlı, ev yapımı',      'fiyat' => '180 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
    ]],
    ['ad' => 'Mezeler', 'urunler' => [
        ['ad' => 'Humus',            'aciklama' => 'Tahin, limon, zeytinyağı',     'fiyat' => '210 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis'], 'gorsel' => 'urun-humus.webp'],
        ['ad' => 'Haydari',          'aciklama' => 'Süzme yoğurt, dereotu',        'fiyat' => '190 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Muhammara',        'aciklama' => 'Ceviz, biber salçası, nar ekşisi', 'fiyat' => '220 ₺', 'etiketler' => ['Vejetaryen']],
        ['ad' => 'Deniz börülcesi',  'aciklama' => 'Sarımsaklı zeytinyağı ile',    'fiyat' => '210 ₺', 'etiketler' => ['Vejetaryen']],
        ['ad' => 'Meze tabağı',      'aciklama' => 'Yedi çeşit, iki kişilik',      'fiyat' => '540 ₺', 'etiketler' => ['Paket servis'], 'gorsel' => 'urun-meze.webp'],
    ]],
    ['ad' => 'Ara Sıcaklar', 'urunler' => [
        ['ad' => 'Sigara böreği',    'aciklama' => 'Beyaz peynir, maydanoz',       'fiyat' => '240 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Kalamar tava',     'aciklama' => 'Tartar sos ile',               'fiyat' => '480 ₺', 'etiketler' => [], 'gorsel' => 'urun-kalamar.webp'],
        ['ad' => 'Karides güveç',    'aciklama' => 'Kaşarlı, fırında',             'fiyat' => '640 ₺', 'etiketler' => ['Paket servis'], 'gorsel' => 'urun-karides.webp'],
        ['ad' => 'Midye tava',       'aciklama' => 'Tarator sos ile',              'fiyat' => '380 ₺', 'etiketler' => []],
    ]],
    ['ad' => 'Salatalar', 'urunler' => [
        ['ad' => 'Mevsim salata',    'aciklama' => 'Günün taze yeşillikleri',      'fiyat' => '180 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Çoban salata',     'aciklama' => 'Domates, salatalık, biber, soğan', 'fiyat' => '170 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Roka salata',      'aciklama' => 'Cherry domates, parmesan',     'fiyat' => '210 ₺', 'etiketler' => ['Vejetaryen']],
        ['ad' => 'Ahtapot salatası', 'aciklama' => 'Kırmızı soğan, dereotu',       'fiyat' => '340 ₺', 'etiketler' => []],
    ]],
    ['ad' => 'Kebaplar', 'urunler' => [
        ['ad' => 'Adana kebap',      'aciklama' => 'Közde, sumak soğanla',         'fiyat' => '480 ₺', 'etiketler' => ['Paket servis']],
        ['ad' => 'Urfa kebap',       'aciklama' => 'Acısız, sumak soğanla',        'fiyat' => '460 ₺', 'etiketler' => ['Paket servis']],
        ['ad' => 'Kuzu şiş',         'aciklama' => 'Marine edilmiş kuzu, közde',   'fiyat' => '580 ₺', 'etiketler' => []],
        ['ad' => 'Tavuk şiş',        'aciklama' => 'Marine edilmiş, közde',        'fiyat' => '380 ₺', 'etiketler' => ['Paket servis']],
        ['ad' => 'Kuzu pirzola',     'aciklama' => '4 parça, biberiye',            'fiyat' => '780 ₺', 'etiketler' => []],
    ]],
    ['ad' => 'Balıklar', 'urunler' => [
        ['ad' => 'Çupra ızgara',     'aciklama' => 'Porsiyon, mevsim yeşilliği ile', 'fiyat' => '780 ₺', 'etiketler' => [], 'gorsel' => 'urun-cupra.webp'],
        ['ad' => 'Levrek ızgara',    'aciklama' => 'Porsiyon, limon sos',          'fiyat' => '760 ₺', 'etiketler' => [], 'gorsel' => 'urun-levrek.webp'],
        ['ad' => 'Somon ızgara',     'aciklama' => 'Fesleğenli sos, karnabahar püresi', 'fiyat' => '720 ₺', 'etiketler' => []],
        ['ad' => 'Ahtapot ızgara',   'aciklama' => 'Közlenmiş patates, limon',     'fiyat' => '920 ₺', 'etiketler' => ['Paket servis'], 'gorsel' => 'urun-ahtapot.webp'],
        ['ad' => 'Karides ızgara',   'aciklama' => 'Sarımsaklı yağda',             'fiyat' => '620 ₺', 'etiketler' => [], 'gorsel' => 'urun-karides.webp'],
    ]],
    ['ad' => 'Pideler', 'urunler' => [
        ['ad' => 'Kaşarlı pide',     'aciklama' => 'Taş fırında',                  'fiyat' => '260 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Kuşbaşılı pide',   'aciklama' => 'Dana kuşbaşı, biber',          'fiyat' => '320 ₺', 'etiketler' => ['Paket servis']],
        ['ad' => 'Sucuklu kaşarlı',  'aciklama' => 'Sucuk, kaşar peyniri',         'fiyat' => '300 ₺', 'etiketler' => ['Paket servis']],
        ['ad' => 'Karışık pide',     'aciklama' => 'Kuşbaşı, sucuk, kaşar',        'fiyat' => '360 ₺', 'etiketler' => ['Paket servis']],
    ]],
    ['ad' => 'Tatlılar', 'urunler' => [
        ['ad' => 'Sütlaç',           'aciklama' => 'Fırında, tarçınlı',            'fiyat' => '150 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Künefe',           'aciklama' => 'Antep fıstığı ile',            'fiyat' => '210 ₺', 'etiketler' => ['Vejetaryen'], 'gorsel' => 'urun-tatli.webp'],
        ['ad' => 'Kazandibi',        'aciklama' => 'Klasik reçeteyle',             'fiyat' => '160 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
        ['ad' => 'Mevsim meyve',     'aciklama' => 'Mevsime göre seçki',           'fiyat' => '180 ₺', 'etiketler' => ['Vejetaryen', 'Paket servis']],
    ]],
];

$varsayilan['sayfalar']['menu'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Menü',
     'baslik' => 'Boğaziçi Mutfağını Keşfedin',
     'alt_baslik' => 'Deniz ürünlerinden Ege’nin sevilen lezzetlerine, mezelerden sıcaklara uzanan Boğaziçi mutfağını keşfedin.',
     'gorsel' => 'basluk-menu.webp', 'gorsel_alt' => ''],
    ['tip' => 'menu-liste', 'zemin' => 'beyaz',
     'alt_baslik' => 'Menü içeriği şubelere ve ürünlerin mevsimsel durumuna göre farklılık gösterebilir.',
     'kategoriler' => $menu_kategorileri],
    ['tip' => 'cta-bant', 'zemin' => 'kum',
     'baslik' => 'Boğaziçi Sofrasında Yerinizi Ayırtın',
     'metin' => 'Seçkin lezzetlerimizi Üçkuyular, Narlıdere ve Bostanlı şubelerimizde keşfedin.',
     'buton_yazi' => 'Rezervasyon yap', 'buton_link' => '/rezervasyon.php',
     'buton2_yazi' => 'Şubelerimiz', 'buton2_link' => '/subeler.php'],
];

$varsayilan['sayfalar']['rezervasyon'] = [
    [
        'tip' => 'rezervasyon-akis', 'zemin' => 'beyaz',
        'ustluk' => 'Rezervasyon', 'baslik' => 'Yeriniz hazır olsun',
        'alt_baslik' => 'Şubenizi seçin, tarih ve saatinizi belirleyin. Rezervasyonunuz mesai saatinde onaylanır.',
    ],
];

$varsayilan['sayfalar']['iletisim'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Boğaziçi Restaurant',
     'baslik' => 'Bizimle İletişime Geçin',
     'alt_baslik' => 'Görüş, öneri ve talepleriniz için bize ulaşabilir; şubelerimiz hakkında detaylı bilgi alabilirsiniz.',
     'gorsel' => 'basluk-iletisim.webp', 'gorsel_alt' => ''],
    ['tip' => 'iletisim', 'zemin' => 'beyaz',
     'ustluk' => 'İletişim', 'baslik' => 'Bize Yazın',
     'metin' => 'Görüş, öneri ve taleplerinizi form aracılığıyla bizimle paylaşabilirsiniz. Ekibimiz en kısa sürede sizinle iletişime geçecektir.'],
    ['tip' => 'sube-iletisim', 'zemin' => 'kum',
     'ustluk' => 'Şubeler', 'baslik' => 'Şubelerimize Ulaşın'],
    ['tip' => 'harita-sekmeli', 'zemin' => 'beyaz',
     'ustluk' => 'Harita', 'baslik' => 'Size En Yakın Boğaziçi'],
    ['tip' => 'genel-iletisim', 'zemin' => 'kum',
     'ustluk' => 'Genel', 'baslik' => 'Genel İletişim',
     'telefon' => '+908508500850', 'telefon_yazi' => '0850 850 0850',
     'eposta' => 'info@bogazicirestaurant.com.tr'],
];

$varsayilan['sayfalar']['kvkk'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Kurumsal',
     'baslik' => 'KVKK Aydınlatma Metni'],
    ['tip' => 'belge', 'zemin' => 'beyaz',
     'guncelleme' => 'Ocak 2026',
     'bolumler' => [
        ['baslik' => 'Veri Sorumlusu', 'metin' => 'İşbu aydınlatma metni, 6698 sayılı Kişisel Verilerin Korunması Kanunu (“KVKK”) uyarınca, Boğaziçi Restaurant (“Boğaziçi”, veri sorumlusu) tarafından işlenen kişisel verileriniz hakkında sizi bilgilendirmek amacıyla hazırlanmıştır.'],
        ['baslik' => 'İşlenen Kişisel Veriler', 'metin' => 'Rezervasyon, iletişim formu ve şube içi işlemleriniz sırasında ad soyad, telefon, e-posta, rezervasyon tercihleri ve mesaj içeriğiniz gibi kişisel verileriniz işlenmektedir.'],
        ['baslik' => 'İşleme Amaçları', 'metin' => 'Kişisel verileriniz; rezervasyon taleplerinizin karşılanması, iletişim formu üzerinden ilettiğiniz talep ve önerilerin yanıtlanması, hizmet kalitesinin artırılması ve yasal yükümlülüklerin yerine getirilmesi amaçlarıyla işlenir.'],
        ['baslik' => 'Aktarım', 'metin' => 'Kişisel verileriniz, yasal zorunluluklar dışında üçüncü kişilerle paylaşılmaz; yalnızca hizmetin sunumu için gerekli iş ortaklarımızla (örn. rezervasyon/SMS altyapı sağlayıcıları) sınırlı ölçüde paylaşılabilir.'],
        ['baslik' => 'Haklarınız', 'metin' => 'KVKK’nın 11. maddesi kapsamında kişisel verilerinizin işlenip işlenmediğini öğrenme, düzeltilmesini veya silinmesini talep etme dahil haklarınızı kullanmak için info@bogazicirestaurant.com.tr adresinden bizimle iletişime geçebilirsiniz.'],
     ]],
];

$varsayilan['sayfalar']['gizlilik'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Kurumsal',
     'baslik' => 'Gizlilik Politikası'],
    ['tip' => 'belge', 'zemin' => 'beyaz',
     'guncelleme' => 'Ocak 2026',
     'bolumler' => [
        ['baslik' => 'Kapsam', 'metin' => 'Bu gizlilik politikası, bogazicirestaurant.com.tr web sitesi üzerinden topladığımız bilgilerin nasıl kullanıldığını ve korunduğunu açıklar.'],
        ['baslik' => 'Toplanan Bilgiler', 'metin' => 'Rezervasyon ve iletişim formları aracılığıyla paylaştığınız ad soyad, telefon, e-posta ve mesaj bilgileri ile sitenin genel kullanım istatistiklerine ilişkin teknik veriler toplanır.'],
        ['baslik' => 'Bilgilerin Kullanımı', 'metin' => 'Toplanan bilgiler yalnızca rezervasyon süreçlerinizin yürütülmesi, taleplerinize dönüş yapılması ve site deneyiminin iyileştirilmesi amacıyla kullanılır; pazarlama amacıyla üçüncü taraflarla paylaşılmaz.'],
        ['baslik' => 'Veri Güvenliği', 'metin' => 'Kişisel verilerinizin güvenliğini sağlamak için makul teknik ve idari tedbirler alınmaktadır. Yine de internet üzerinden yapılan hiçbir veri aktarımının %100 güvenli olduğu garanti edilemez.'],
        ['baslik' => 'İletişim', 'metin' => 'Gizlilik politikamızla ilgili sorularınız için info@bogazicirestaurant.com.tr adresinden bize ulaşabilirsiniz.'],
     ]],
];

$varsayilan['sayfalar']['cerez'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Kurumsal',
     'baslik' => 'Çerez Aydınlatma Metni'],
    ['tip' => 'belge', 'zemin' => 'beyaz',
     'guncelleme' => 'Ocak 2026',
     'bolumler' => [
        ['baslik' => 'Çerez Nedir?', 'metin' => 'Çerezler, ziyaret ettiğiniz web siteleri tarafından tarayıcınıza kaydedilen küçük metin dosyalarıdır. Sitemizin düzgün çalışmasını ve deneyiminizi iyileştirmeyi sağlarlar.'],
        ['baslik' => 'Kullanılan Çerez Türleri', 'metin' => 'Sitemizde; temel site işlevlerini sağlayan zorunlu çerezler ile ziyaretçi davranışlarını anonim biçimde ölçen performans/analiz çerezleri kullanılmaktadır.'],
        ['baslik' => 'Çerez Yönetimi', 'metin' => 'Tarayıcı ayarlarınız üzerinden çerezleri silebilir veya engelleyebilirsiniz. Ancak zorunlu çerezlerin engellenmesi, sitenin bazı bölümlerinin düzgün çalışmamasına neden olabilir.'],
        ['baslik' => 'İletişim', 'metin' => 'Çerez kullanımımızla ilgili sorularınız için info@bogazicirestaurant.com.tr adresinden bize ulaşabilirsiniz.'],
     ]],
];

$varsayilan['sayfalar']['ik'] = [
    ['tip' => 'sayfa-basligi', 'zemin' => 'koyu', 'ustluk' => 'Kurumsal',
     'baslik' => 'İnsan Kaynakları'],
    ['tip' => 'belge', 'zemin' => 'beyaz',
     'bolumler' => [
        ['baslik' => 'Neden Boğaziçi?', 'metin' => '1993’ten bu yana İzmir’de aynı özenle hizmet veren ekibimiz, üç şubede büyümeye devam ediyor. Boğaziçi ailesinde uzun soluklu bir kariyer, güçlü bir mutfak kültürü ve misafirperverlik anlayışı sizi bekliyor.'],
        ['baslik' => 'Açık Pozisyonlar', 'metin' => 'Şu anda güncel ilan bulunmasa da, mutfak, servis ve yönetim alanlarında özgeçmişinizi değerlendirmek üzere ik@bogazicirestaurant.com.tr adresine iletebilirsiniz.'],
        ['baslik' => 'Başvuru Süreci', 'metin' => 'Başvurunuz İnsan Kaynakları ekibimiz tarafından değerlendirilir; uygun bir pozisyon açıldığında sizinle iletişime geçilir.'],
        ['baslik' => 'KVKK Bilgilendirmesi', 'metin' => 'Paylaştığınız özgeçmiş ve iletişim bilgileri, yalnızca işe alım süreçleri kapsamında işlenir. Detaylı bilgi için KVKK Aydınlatma Metni’ni inceleyebilirsiniz.'],
     ]],
];

return $varsayilan;
