<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   v-2 İÇERİK — Boğaziçi Restaurant (İzmir)
   Şubeler: Üçkuyular · Narlıdere · Bostanlı
   Telefon 0850 ve e-postalar müşteri onayına bağlı; koordinatlar
   yaklaşık — gerçek konum bilgisiyle güncellenebilir.
   -------------------------------------------------------------- */

const SUBELER = [
    [
        'slug'         => 'uckuyular',
        'ad'           => 'Üçkuyular',
        'adres'        => 'Bahçeler Arası Mah. Haydar Aliyev Bulvarı No: 2/A, Balçova / İzmir',
        'telefon'      => '+908508500850',
        'telefon_yazi' => '0850 850 0850',
        'eposta'       => 'uckuyular@bogazicirestaurant.com.tr',
        'saat'         => 'Her gün 12:00 – 24:00',
        'gorsel'       => 'sube-uckuyular.webp',
        'enlem'        => 38.3873,
        'boylam'       => 27.0399,
        'yol_tarifi'   => 'https://www.google.com/maps/search/?api=1&query=Bogazici+Restaurant+Uckuyular+Balcova',
        'bolgeler' => [
            ['id' => 'ic-salon',      'ad' => 'İç Salon',       'aciklama' => 'Klimalı, sakin, aile için ideal',  'kapasite' => 40, 'musait' => 12],
            ['id' => 'teras',         'ad' => 'Teras',           'aciklama' => 'Üstü açık, akşam serin',           'kapasite' => 24, 'musait' => 6],
            ['id' => 'bahce',         'ad' => 'Bahçe',           'aciklama' => 'Zeytin ağaçlarının altı',          'kapasite' => 20, 'musait' => 4],
            ['id' => 'deniz-kenari',  'ad' => 'Deniz Kenarı',    'aciklama' => 'Körfez manzaralı cephe',           'kapasite' => 16, 'musait' => 2],
        ],
    ],
    [
        'slug'         => 'narlidere',
        'ad'           => 'Narlıdere',
        'adres'        => 'Limanreis Mah. Mithatpaşa Cd. No: 606, 35320 Narlıdere / İzmir',
        'telefon'      => '+908508500850',
        'telefon_yazi' => '0850 850 0850',
        'eposta'       => 'narlidere@bogazicirestaurant.com.tr',
        'saat'         => 'Her gün 11:00 – 01:00',
        'gorsel'       => 'sube-narlidere.webp',
        'enlem'        => 38.3925,
        'boylam'       => 27.0060,
        'yol_tarifi'   => 'https://www.google.com/maps/search/?api=1&query=Bogazici+Restaurant+Narlidere',
        'bolgeler' => [
            ['id' => 'ic-salon',      'ad' => 'İç Salon',       'aciklama' => 'Denize bakan cepheli iç mekân',    'kapasite' => 36, 'musait' => 8],
            ['id' => 'teras',         'ad' => 'Teras',           'aciklama' => 'Üst kat, panoramik',               'kapasite' => 28, 'musait' => 10],
            ['id' => 'bahce',         'ad' => 'Bahçe',           'aciklama' => 'Palmiye altında',                  'kapasite' => 22, 'musait' => 5],
            ['id' => 'deniz-kenari',  'ad' => 'Deniz Kenarı',    'aciklama' => 'Sahil platformu',                  'kapasite' => 12, 'musait' => 3],
        ],
    ],
    [
        'slug'         => 'bostanli',
        'ad'           => 'Bostanlı',
        'adres'        => 'Cengiz Topel Caddesi No: 38/B, Bostanlı – İzmir',
        'telefon'      => '+908508500850',
        'telefon_yazi' => '0850 850 0850',
        'eposta'       => 'bostanli@bogazicirestaurant.com.tr',
        'saat'         => 'Her gün 12:00 – 24:00',
        'gorsel'       => 'sube-bostanli.webp',
        'enlem'        => 38.4664,
        'boylam'       => 27.0975,
        'yol_tarifi'   => 'https://www.google.com/maps/search/?api=1&query=Bogazici+Restaurant+Bostanli+Izmir',
        'paket_servis' => '/v-2/hizmetler.php#paket-servis',
        'bolgeler' => [
            ['id' => 'ic-salon',      'ad' => 'İç Salon',       'aciklama' => 'Geniş salon, grup için uygun',      'kapasite' => 48, 'musait' => 20],
            ['id' => 'teras',         'ad' => 'Teras',           'aciklama' => 'Rüzgâra korumalı üst kat',          'kapasite' => 20, 'musait' => 7],
            ['id' => 'bahce',         'ad' => 'Bahçe',           'aciklama' => 'Çim alan, çocuk dostu',             'kapasite' => 24, 'musait' => 9],
            ['id' => 'deniz-kenari',  'ad' => 'Deniz Kenarı',    'aciklama' => 'Bostanlı sahili',                   'kapasite' => 14, 'musait' => 0],
        ],
    ],
];

/* --------------------------------------------------------------
   Sayfalar
   -------------------------------------------------------------- */
$sayfalar = [];

/* ---------- ANASAYFA ---------- */
$sayfalar['anasayfa'] = [
    [
        'tip'         => 'hero',
        'ustluk'      => 'BOĞAZİÇİ RESTAURANT',
        'baslik'      => 'İzmir’de Lezzetin Buluşma Noktası',
        'alt_baslik'  => 'Üç şubemizde, özenle hazırlanan sofraları kaliteli hizmet ve Boğaziçi deneyimiyle buluşturuyoruz.',
        'ek_yazi'     => 'Üçkuyular · Narlıdere · Bostanlı',
        'gorsel'      => 'hero-anasayfa.webp',
        'gorsel_alt'  => 'Boğaziçi Restaurant salonu',
        'butonlar'    => [
            ['yazi' => 'Şubelerimizi Keşfedin', 'link' => '/v-2/subeler.php',      'tur' => 'birincil'],
            ['yazi' => 'Rezervasyon',           'link' => '/v-2/rezervasyon.php',  'tur' => 'ikincil'],
        ],
    ],

    [
        'tip'         => 'hikaye',
        'numara'      => '01',
        'ustluk'      => 'Boğaziçi Dokunuşu',
        'baslik'      => 'Yemekte Boğaziçi Dokunuşu',
        'metin'       => 'İyi bir yemeğin yalnızca lezzetten ibaret olmadığına inanıyoruz. Özenli sunum, kaliteli ürünler ve güçlü hizmet anlayışımızla her buluşmayı keyifli bir deneyime dönüştürüyoruz. Üç farklı lokasyon, aynı Boğaziçi deneyimi.',
        'gorsel'      => 'hikaye-dokunus.webp',
        'gorsel_alt'  => 'Boğaziçi sofrası',
        'yon'         => 'sag',
    ],

    [
        'tip'    => 'hizmet-serit',
        'ogeler' => [
            ['ikon' => 'kalem', 'ad' => 'Özenli Mutfak',   'metin' => 'Seçkin ürünler, özenli hazırlık.'],
            ['ikon' => 'takim', 'ad' => 'Kaliteli Hizmet', 'metin' => 'Misafir memnuniyetini merkeze alan servis anlayışı.'],
            ['ikon' => 'kutu',  'ad' => 'Keyifli Atmosfer','metin' => 'Her buluşmaya eşlik eden sıcak ve şık mekânlar.'],
        ],
    ],

    [
        'tip'         => 'sube-onizleme',
        'varyant'     => 'anasayfa',
        'numara'      => '02',
        'ustluk'      => 'Şubeler',
        'baslik'      => 'Size En Yakın Boğaziçi',
        'alt_baslik'  => 'İzmir’in üç farklı noktasında aynı lezzet ve hizmet anlayışı.',
    ],

    [
        'tip'         => 'hikaye',
        'numara'      => '03',
        'ustluk'      => 'Menü',
        'baslik'      => 'Her Sofraya Bir Boğaziçi Klasiği',
        'metin'       => 'Geleneksel tatlardan özenle hazırlanan özel lezzetlere uzanan menümüzle, günün her anına eşlik eden zengin bir sofra sunuyoruz.',
        'gorsel'      => 'hikaye-menu.webp',
        'gorsel_alt'  => 'Boğaziçi klasiği',
        'yon'         => 'sol',
        'buton'       => ['yazi' => 'Menüyü İncele', 'link' => '/v-2/menu.php', 'tur' => 'ikincil'],
    ],

    [
        'tip'         => 'sube-kareler',
        'ustluk'      => 'Kareler',
        'baslik'      => 'Boğaziçi’nden Kareler',
        'alt_baslik'  => 'Üç farklı lokasyon, aynı Boğaziçi atmosferi.',
    ],

    [
        'tip'         => 'kapanis',
        'numara'      => '04',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Yeriniz Hazır',
        'alt_baslik'  => 'Boğaziçi deneyimini Üçkuyular, Narlıdere veya Bostanlı şubemizde yaşayın.',
        'buton_yazi'  => 'Rezervasyon Yap',
        'buton_link'  => '/v-2/rezervasyon.php',
        'buton2_yazi' => 'Şubeleri Gör',
        'buton2_link' => '/v-2/subeler.php',
    ],
];

/* ---------- ŞUBELER ---------- */
$sayfalar['subeler'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'BOĞAZİÇİ RESTAURANT',
        'baslik'      => 'Üç Şube, Tek Boğaziçi Deneyimi',
        'alt_baslik'  => 'İzmir’in üç farklı noktasında, aynı özenli hizmet anlayışı ve Boğaziçi lezzetleriyle sizi ağırlıyoruz.',
    ],
    [
        'tip'    => 'sube-detay',
        'slug'   => 'uckuyular',
        'numara' => '01',
        'yon'    => 'sag',
        'metin'  => 'Balçova, Haydar Aliyev Bulvarı üzerinde. Körfez’e bakan cepheli konumu ve rahat ulaşımıyla hem öğle hem akşam servisi için tercih edilen bir Boğaziçi noktası.',
    ],
    [
        'tip'    => 'sube-detay',
        'slug'   => 'narlidere',
        'numara' => '02',
        'yon'    => 'sol',
        'metin'  => 'Mithatpaşa Caddesi üzerinde, sahile yakın konum. Yaz aylarında rezervasyon avantaj sağlar; iç mekân ve terasıyla geniş kapasite sunar.',
    ],
    [
        'tip'    => 'sube-detay',
        'slug'   => 'bostanli',
        'numara' => '03',
        'yon'    => 'sag',
        'metin'  => 'Cengiz Topel Caddesi’nde, 1993’ten bu yana açık olan ilk Boğaziçi şubesi. Bostanlı sahiline yürüme mesafesinde, aile grupları için tercih edilen mekân.',
    ],
    [
        'tip'         => 'kapanis',
        'numara'      => '04',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Üç Farklı Lokasyon, Aynı Boğaziçi',
        'alt_baslik'  => 'İzmir’in üç farklı noktasında, aynı özen ve hizmet anlayışıyla sizi ağırlıyoruz.',
        'buton_yazi'  => 'Rezervasyon Yap',
        'buton_link'  => '/v-2/rezervasyon.php',
    ],
];

/* ---------- KURUMSAL ---------- */
$sayfalar['kurumsal'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'BOĞAZİÇİ RESTAURANT',
        'baslik'      => '1993’ten Bugüne, Aynı Özenle',
        'alt_baslik'  => 'İzmir’de başlayan Boğaziçi yolculuğu, bugün Bostanlı, Üçkuyular ve Narlıdere’de aynı kalite ve hizmet anlayışıyla devam ediyor.',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '01',
        'ustluk'      => 'Hikâyemiz',
        'baslik'      => 'İzmir’de Bir Boğaziçi Klasiği',
        'metin'       => 'Boğaziçi Restaurant’ın yolculuğu 1993 yılında Bostanlı’da başladı. 2010 yılında Üçkuyular, 2017 yılında ise Narlıdere şubesinin katılmasıyla Boğaziçi lezzetleri İzmir Körfezi’nin farklı noktalarında misafirleriyle buluşmaya devam etti. Yıllar içinde değişen ve gelişen menümüzü; kaliteli ürün, özenli hazırlık ve misafir memnuniyetini merkeze alan hizmet anlayışımızla bir araya getiriyoruz. Bugün üç şubemizde, yılların deneyimini her sofraya aynı özenle taşıyoruz.',
        'gorsel'      => 'kurumsal-baslangic.webp',
        'gorsel_alt'  => 'Bostanlı — ilk şube',
        'yon'         => 'sag',
    ],
    [
        'tip'    => 'zaman-cizelgesi',
        'ustluk' => 'Zaman Çizgisi',
        'baslik' => '30 Yılı Aşan Bir Hikâye',
        'ogeler' => [
            ['yil' => '1993',  'olay' => 'Bostanlı — Boğaziçi Restaurant’ın İzmir’deki yolculuğu başladı.'],
            ['yil' => '2010',  'olay' => 'Üçkuyular — Boğaziçi deneyimi Körfez’in diğer yakasına taşındı.'],
            ['yil' => '2017',  'olay' => 'Narlıdere — Üçüncü şubemizle İzmir’deki hizmet ağımız genişledi.'],
            ['yil' => 'BUGÜN', 'olay' => 'Üç Şube, Tek Boğaziçi — üç şubemizde aynı hizmet anlayışıyla ağırlamaya devam ediyoruz.'],
        ],
    ],
    [
        'tip'    => 'degerler',
        'ustluk' => 'Değerlerimiz',
        'baslik' => 'Boğaziçi’nin Değişmeyen Değerleri',
        'ogeler' => [
            ['ikon' => 'terazi', 'baslik' => 'Kalite',           'metin' => 'Ürün seçiminden sunuma kadar her aşamada kaliteyi ön planda tutuyoruz.'],
            ['ikon' => 'yaprak', 'baslik' => 'Özen',             'metin' => 'Her tabağı, her sofrayı ve her misafirimizi Boğaziçi deneyiminin bir parçası olarak görüyoruz.'],
            ['ikon' => 'el',     'baslik' => 'Misafirperverlik', 'metin' => 'Yılların deneyimini güler yüzlü ve özenli hizmet anlayışıyla buluşturuyoruz.'],
        ],
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '02',
        'ustluk'      => 'Mutfak Anlayışımız',
        'baslik'      => 'Lezzetin Temelinde Kalite Var',
        'metin'       => 'Mevsiminde balık çeşitlerinden yöresel kebaplara, Ege mutfağının zeytinyağlılarından sıcak ve soğuk mezelere uzanan zengin mutfağımızda, ürün kalitesini ve tazeliği ön planda tutuyoruz.',
        'gorsel'      => 'kurumsal-mutfak.webp',
        'gorsel_alt'  => 'Mutfakta hazırlık',
        'yon'         => 'sol',
    ],
    [
        'tip'    => 'alinti',
        'metin'  => 'İyi Ye, İyi Yaşa.',
        'kaynak' => 'Boğaziçi Restaurant',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '03',
        'ustluk'      => 'Kalite & Hijyen',
        'baslik'      => 'Kalite, Boğaziçi’nin Temelidir',
        'metin'       => 'Sağlıklı ürün, hijyen ve kaliteli hizmet anlayışını mutfağımızın temel standartları arasında görüyoruz. Et ve balık hazırlama süreçlerinin ayrı mutfaklarda yürütülmesi dahil olmak üzere, mutfak organizasyonumuzu kalite ve hijyen anlayışımız doğrultusunda sürdürüyoruz.',
        'gorsel'      => 'kurumsal-hijyen.webp',
        'gorsel_alt'  => 'Hijyen standartları',
        'yon'         => 'sag',
    ],
    [
        'tip'         => 'kapanis',
        'numara'      => '04',
        'ustluk'      => 'Deneyim',
        'baslik'      => 'Boğaziçi Deneyimini Keşfedin',
        'alt_baslik'  => 'Bostanlı, Üçkuyular ve Narlıdere şubelerimizde sizi aynı özen ve misafirperverlikle karşılıyoruz.',
        'buton_yazi'  => 'Şubelerimiz',
        'buton_link'  => '/v-2/subeler.php',
        'buton2_yazi' => 'Rezervasyon',
        'buton2_link' => '/v-2/rezervasyon.php',
    ],
];

/* ---------- MENÜ ---------- */
$sayfalar['menu'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'Menü',
        'baslik'      => 'Boğaziçi Mutfağını Keşfedin',
        'alt_baslik'  => 'Deniz ürünlerinden Ege’nin sevilen lezzetlerine, mezelerden sıcaklara uzanan Boğaziçi mutfağını keşfedin. Menü içeriği şubelere ve ürünlerin mevsimsel durumuna göre farklılık gösterebilir.',
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '01',
        'ad'       => 'Başlangıçlar',
        'aciklama' => 'Sofraya sıcak bir açılış.',
        'ogeler'   => [
            ['ad' => 'Mercimek Çorbası',     'aciklama' => 'Limon, tereyağı',                       'fiyat' => '120'],
            ['ad' => 'Balık Çorbası',        'aciklama' => 'Günün taze balığından',                 'fiyat' => '260'],
            ['ad' => 'Yaprak Sarma',         'aciklama' => 'Zeytinyağlı, ev yapımı',                'fiyat' => '180'],
        ],
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '02',
        'ad'       => 'Mezeler',
        'aciklama' => 'Boğaziçi sofralarının sevilen başlangıçları.',
        'ogeler'   => [
            ['ad' => 'Humus',                'aciklama' => 'Nohut, tahin, limon, zeytinyağı',       'fiyat' => '180'],
            ['ad' => 'Haydari',              'aciklama' => 'Süzme yoğurt, dereotu, sarımsak',       'fiyat' => '160'],
            ['ad' => 'Ezme',                 'aciklama' => 'Ateşte közlenmiş biber ve domates',     'fiyat' => '170'],
            ['ad' => 'Muhammara',            'aciklama' => 'Ceviz, biber salçası, nar ekşisi',      'fiyat' => '210'],
            ['ad' => 'Fava',                 'aciklama' => 'Bakla püresi, dereotu, kırmızı soğan',  'fiyat' => '180'],
            ['ad' => 'Deniz Börülcesi',      'aciklama' => 'Sarımsaklı, limonlu',                   'fiyat' => '200'],
            ['ad' => 'Enginar Zeytinyağlı',  'aciklama' => 'Ayvalık zeytinyağında pişirilmiş',      'fiyat' => '220'],
            ['ad' => 'Cacık',                'aciklama' => 'Yoğurt, salatalık, nane',               'fiyat' => '140'],
        ],
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '03',
        'ad'       => 'Ara Sıcaklar',
        'aciklama' => 'Sofranın ritmini tamamlayan sıcak lezzetler.',
        'ogeler'   => [
            ['ad' => 'Sigara Böreği',    'aciklama' => 'Beyaz peynir, maydanoz',      'fiyat' => '180'],
            ['ad' => 'Kalamar Tava',     'aciklama' => 'Tarator sos ile',             'fiyat' => '320'],
            ['ad' => 'Karides Güveç',    'aciklama' => 'Domates, biber, kaşar',       'fiyat' => '450'],
            ['ad' => 'Midye Tava',       'aciklama' => 'Tarator sos ile',             'fiyat' => '340'],
            ['ad' => 'Arnavut Ciğeri',   'aciklama' => 'Sumak, kırmızı soğan',        'fiyat' => '260'],
            ['ad' => 'Peynirli Sac Böreği','aciklama' => 'İnce yufka, taze peynir',   'fiyat' => '220'],
        ],
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '04',
        'ad'       => 'Salatalar',
        'aciklama' => 'Taze ve özenle seçilmiş malzemelerle hazırlanan ferah lezzetler.',
        'ogeler'   => [
            ['ad' => 'Mevsim Salata',    'aciklama' => 'Günün taze yeşillikleri',        'fiyat' => '180'],
            ['ad' => 'Çoban Salata',     'aciklama' => 'Domates, salatalık, biber, soğan','fiyat' => '170'],
            ['ad' => 'Roka Salata',      'aciklama' => 'Cherry domates, parmesan',       'fiyat' => '210'],
            ['ad' => 'Akdeniz Salatası', 'aciklama' => 'Peynir, zeytin, marul',          'fiyat' => '260'],
        ],
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '05',
        'ad'       => 'Kebaplar',
        'aciklama' => 'Ateşin ve ustalığın buluştuğu klasikler.',
        'ogeler'   => [
            ['ad' => 'Adana Kebap',   'aciklama' => 'Közde, sumak soğanla',           'fiyat' => '480'],
            ['ad' => 'Urfa Kebap',    'aciklama' => 'Acısız, sumak soğanla',          'fiyat' => '460'],
            ['ad' => 'Kuzu Şiş',      'aciklama' => 'Marine edilmiş kuzu, közde',     'fiyat' => '580'],
            ['ad' => 'Tavuk Şiş',     'aciklama' => 'Marine edilmiş, közde',          'fiyat' => '380'],
            ['ad' => 'Kuzu Pirzola',  'aciklama' => '4 parça, biberiye',              'fiyat' => '780'],
            ['ad' => 'Bonfile',       'aciklama' => '200 gr, mantar sos',             'fiyat' => '850'],
        ],
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '06',
        'ad'       => 'Balıklar',
        'aciklama' => 'Denizden gelen seçkin lezzetler, Boğaziçi dokunuşuyla.',
        'ogeler'   => [
            ['ad' => 'Levrek Izgara',  'aciklama' => 'Limon ve rezene ile',                'fiyat' => '650'],
            ['ad' => 'Çipura Izgara',  'aciklama' => 'Zeytinyağı ve kekik',                'fiyat' => '620'],
            ['ad' => 'Somon',          'aciklama' => 'Fesleğenli sos, karnabahar püresi',  'fiyat' => '720'],
            ['ad' => 'Ahtapot Izgara', 'aciklama' => 'Kimyon ve limon',                    'fiyat' => '780'],
            ['ad' => 'Karides Izgara', 'aciklama' => 'Sarımsaklı yağda',                   'fiyat' => '620'],
        ],
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '07',
        'ad'       => 'Pideler',
        'aciklama' => 'Taş fırından, ince hamur, cömert malzeme.',
        'ogeler'   => [
            ['ad' => 'Kaşarlı Pide',        'aciklama' => 'Taş fırında',              'fiyat' => '260'],
            ['ad' => 'Kuşbaşılı Pide',      'aciklama' => 'Dana kuşbaşı, biber',      'fiyat' => '320'],
            ['ad' => 'Sucuklu Kaşarlı Pide','aciklama' => 'Sucuk, kaşar peyniri',     'fiyat' => '300'],
            ['ad' => 'Karışık Pide',        'aciklama' => 'Kuşbaşı, sucuk, kaşar',    'fiyat' => '360'],
        ],
    ],
    [
        'tip'      => 'menu-bolum',
        'numara'   => '08',
        'ad'       => 'Tatlılar',
        'aciklama' => 'Boğaziçi sofrasını tatlı bir dokunuşla tamamlayan lezzetler.',
        'ogeler'   => [
            ['ad' => 'Sütlaç',       'aciklama' => 'Fırında, tarçınlı',    'fiyat' => '150'],
            ['ad' => 'Kazandibi',    'aciklama' => 'Klasik reçeteyle',     'fiyat' => '160'],
            ['ad' => 'Künefe',       'aciklama' => 'Antep fıstığı ile',    'fiyat' => '210'],
            ['ad' => 'Mevsim Meyve', 'aciklama' => 'Mevsime göre seçki',   'fiyat' => '180'],
        ],
    ],
    [
        'tip'         => 'kapanis',
        'numara'      => '09',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Boğaziçi Sofrasında Yerinizi Ayırtın',
        'alt_baslik'  => 'Seçkin lezzetlerimizi Üçkuyular, Narlıdere ve Bostanlı şubelerimizde keşfedin.',
        'buton_yazi'  => 'Rezervasyon Yap',
        'buton_link'  => '/v-2/rezervasyon.php',
        'buton2_yazi' => 'Şubelerimiz',
        'buton2_link' => '/v-2/subeler.php',
    ],
];

/* ---------- HİZMETLER ---------- */
$sayfalar['hizmetler'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'BOĞAZİÇİ RESTAURANT',
        'baslik'      => 'Her Buluşmaya Boğaziçi Dokunuşu',
        'alt_baslik'  => 'İş dünyasından özel davetlere, farklı ihtiyaçlara özenli mutfak ve profesyonel hizmet anlayışımızla eşlik ediyoruz.',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '01',
        'ustluk'      => 'İş Toplantıları & Seminerler',
        'baslik'      => 'İş Buluşmalarınıza Özenli Bir Ev Sahipliği',
        'metin'       => 'İş yemekleri, kurumsal buluşmalar, toplantılar ve seminerler için Boğaziçi’nin hizmet anlayışını profesyonel organizasyon deneyimiyle bir araya getiriyoruz.',
        'gorsel'      => 'hizmet-toplanti.webp',
        'gorsel_alt'  => 'İş toplantısı',
        'yon'         => 'sag',
        'buton'       => ['yazi' => 'Bilgi Al', 'link' => '/v-2/iletisim.php#form', 'tur' => 'ikincil'],
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '02',
        'ustluk'      => 'Kokteyl & Etkinlik',
        'baslik'      => 'Özel Anlara Özenli Dokunuşlar',
        'metin'       => 'Kurumsal etkinliklerden özel davetlere, farklı organizasyon ihtiyaçlarını Boğaziçi mutfağı ve hizmet kalitesiyle buluşturuyoruz.',
        'gorsel'      => 'hizmet-kokteyl.webp',
        'gorsel_alt'  => 'Kokteyl servisi',
        'yon'         => 'sol',
        'buton'       => ['yazi' => 'Organizasyon Bilgisi Al', 'link' => '/v-2/iletisim.php#form', 'tur' => 'ikincil'],
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '03',
        'ustluk'      => 'Catering',
        'baslik'      => 'Boğaziçi Lezzetleri Dilediğiniz Yerde',
        'metin'       => 'Toplantı, davet ve özel organizasyonlarınız için Boğaziçi mutfağının deneyimini bulunduğunuz mekâna taşıyoruz. 100 kişiye kadar planlanabilen paketlerle özel gününüzü kolaylaştırıyoruz.',
        'gorsel'      => 'hizmet-catering.webp',
        'gorsel_alt'  => 'Catering paketleri',
        'yon'         => 'sag',
        'buton'       => ['yazi' => 'Catering İçin Bilgi Al', 'link' => '/v-2/iletisim.php#form', 'tur' => 'ikincil'],
    ],
    [
        'tip'         => 'hikaye',
        'id'          => 'paket-servis',
        'numara'      => '04',
        'ustluk'      => 'Paket Servis',
        'baslik'      => 'Boğaziçi Lezzetleri Size Gelsin',
        'metin'       => 'Sevdiğiniz Boğaziçi lezzetlerini restoran deneyiminden ödün vermeden, özenli hazırlık ve paketleme anlayışıyla sofranıza ulaştırıyoruz.',
        'gorsel'      => 'hizmet-paket.webp',
        'gorsel_alt'  => 'Paket servis',
        'yon'         => 'sol',
        'buton'       => ['yazi' => 'Paket Servis Bilgi Al', 'link' => '/v-2/iletisim.php#form', 'tur' => 'ikincil'],
    ],
    [
        'tip'         => 'kapanis',
        'numara'      => '05',
        'ustluk'      => 'İletişim',
        'baslik'      => 'İhtiyacınıza Özel Çözümler',
        'alt_baslik'  => 'Organizasyon, catering ve diğer hizmetlerimiz hakkında detaylı bilgi almak için ekibimizle iletişime geçebilirsiniz.',
        'buton_yazi'  => 'Bilgi Alın',
        'buton_link'  => '/v-2/iletisim.php#form',
        'buton2_yazi' => 'İletişim',
        'buton2_link' => '/v-2/iletisim.php',
    ],
];

/* ---------- İLETİŞİM ---------- */
$sayfalar['iletisim'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'BOĞAZİÇİ RESTAURANT',
        'baslik'      => 'Bizimle İletişime Geçin',
        'alt_baslik'  => 'Görüş, öneri ve talepleriniz için bize ulaşabilir; şubelerimiz hakkında detaylı bilgi alabilirsiniz.',
    ],
    [
        'tip' => 'iletisim-form',
        // deger / hatalar / basari / csrf → iletisim.php POST handler tarafından enjekte edilir
    ],
    [
        'tip'         => 'sube-onizleme',
        'varyant'     => 'iletisim',
        'ustluk'      => 'Şubeler',
        'baslik'      => 'Şubelerimize Ulaşın',
        'alt_baslik'  => 'Adres, telefon ve e-posta bilgileri.',
    ],
    [
        'tip'         => 'harita-sekmeli',
        'ustluk'      => 'Harita',
        'baslik'      => 'Size En Yakın Boğaziçi',
        'alt_baslik'  => 'Şubemizi seçin, konumu görün.',
    ],
    [
        'tip'         => 'genel-iletisim',
        'ustluk'      => 'Genel',
        'baslik'      => 'Genel İletişim',
        'telefon'     => '+908508500850',
        'telefon_yazi'=> '0850 850 0850',
        'eposta'      => 'info@bogazicirestaurant.com.tr',
    ],
];

/* ---------- GALERİ (nav'dan kaldırıldı; dosya erişilir kalıyor) ---------- */
$sayfalar['galeri'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'Galeri',
        'baslik'      => 'Sofradan sahneler',
        'alt_baslik'  => 'Bu sayfa artık ana menüde yok; içerik ileride yayına alınabilir.',
    ],
];
