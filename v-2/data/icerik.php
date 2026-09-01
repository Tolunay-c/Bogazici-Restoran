<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   v-2 GEÇİCİ İÇERİK
   Şubeler ve rezervasyon bölgeleri.
   Gerçek kroki müşteriden gelene kadar bölgeler placeholder.
   -------------------------------------------------------------- */

const SUBELER = [
    [
        'slug'         => 'alsancak',
        'ad'           => 'Alsancak',
        'adres'        => 'Alsancak Mah. Kordon Cad. No: 12, Konak / İzmir',
        'telefon'      => '+902321234567',
        'telefon_yazi' => '0232 123 45 67',
        'saat'         => 'Her gün 12:00 – 24:00',
        'gorsel'       => 'sube-alsancak.webp',
        'enlem'        => 38.4310,   // YER TUTUCU
        'boylam'       => 27.1400,   // YER TUTUCU
        'yol_tarifi'   => 'https://maps.google.com/?q=Bogazici+Restaurant+Alsancak',
        // Placeholder — gerçek plan gelince rezervasyon.php içindeki SVG değişir
        'bolgeler' => [
            ['id' => 'ic-salon',      'ad' => 'İç Salon',       'aciklama' => 'Klimalı, sakin, aile için ideal',  'kapasite' => 40, 'musait' => 12],
            ['id' => 'teras',         'ad' => 'Teras',           'aciklama' => 'Üstü açık, akşam serin',           'kapasite' => 24, 'musait' => 6],
            ['id' => 'bahce',         'ad' => 'Bahçe',           'aciklama' => 'Zeytin ağaçlarının altı',          'kapasite' => 20, 'musait' => 4],
            ['id' => 'deniz-kenari',  'ad' => 'Deniz Kenarı',    'aciklama' => 'Kordon manzaralı, gün batımı',     'kapasite' => 16, 'musait' => 2],
        ],
    ],
    [
        'slug'         => 'cesme',
        'ad'           => 'Çeşme',
        'adres'        => 'Ilıca Mah. Sahil Cad. No: 4, Çeşme / İzmir',
        'telefon'      => '+902327654321',
        'telefon_yazi' => '0232 765 43 21',
        'saat'         => 'Her gün 11:00 – 01:00',
        'gorsel'       => 'sube-cesme.webp',
        'enlem'        => 38.3050,   // YER TUTUCU
        'boylam'       => 26.3550,   // YER TUTUCU
        'yol_tarifi'   => 'https://maps.google.com/?q=Bogazici+Restaurant+Cesme',
        'bolgeler' => [
            ['id' => 'ic-salon',      'ad' => 'İç Salon',       'aciklama' => 'Denize bakan cepheli iç mekân',    'kapasite' => 36, 'musait' => 8],
            ['id' => 'teras',         'ad' => 'Teras',           'aciklama' => 'Üst kat, panoramik',               'kapasite' => 28, 'musait' => 10],
            ['id' => 'bahce',         'ad' => 'Bahçe',           'aciklama' => 'Palmiye altında, canlı müzik',     'kapasite' => 22, 'musait' => 5],
            ['id' => 'deniz-kenari',  'ad' => 'Deniz Kenarı',    'aciklama' => 'İskeleye açılan platform',         'kapasite' => 12, 'musait' => 3],
        ],
    ],
    [
        'slug'         => 'karsiyaka',
        'ad'           => 'Karşıyaka',
        'adres'        => 'Bostanlı Mah. Sahil Bulvarı No: 88, Karşıyaka / İzmir',
        'telefon'      => '+902329876543',
        'telefon_yazi' => '0232 987 65 43',
        'saat'         => 'Her gün 12:00 – 24:00',
        'gorsel'       => 'sube-karsiyaka.webp',
        'enlem'        => 38.4560,   // YER TUTUCU
        'boylam'       => 27.1000,   // YER TUTUCU
        'yol_tarifi'   => 'https://maps.google.com/?q=Bogazici+Restaurant+Karsiyaka',
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

$sayfalar['anasayfa'] = [

    [
        'tip'         => 'hero',
        'ustluk'      => '1998’den beri İzmir’de',
        'baslik'      => 'Denizin sofraya en kısa yolu',
        'alt_baslik'  => 'Günlük tezgâh, üç şube, aynı mutfak. Akşam için yeriniz hazır olsun.',
        'gorsel'      => 'hero-anasayfa.webp',
        'gorsel_alt'  => 'Kordon’a bakan teras ve akşam servisi',
        'butonlar'    => [
            ['yazi' => 'Rezervasyon yap', 'link' => '/rezervasyon.php', 'tur' => 'birincil'],
            ['yazi' => 'Menüyü incele',   'link' => '/menu.php',        'tur' => 'ikincil'],
        ],
    ],

    [
        'tip'         => 'hikaye',
        'numara'      => '01',
        'ustluk'      => 'Deniz',
        'baslik'      => 'Tezgâhtan sofraya, aynı gün',
        'metin'       => 'Balık her sabah İzmir hâlinden geliyor; menü mevsime göre değişiyor. Meze tabaklarımız günlük hazırlanıyor, hiçbiri bir gün öncesinden kalmıyor. Şubeler arasında tarif farkı yok — Çeşme’de yediğiniz humus Karşıyaka’da da aynı.',
        'gorsel'      => 'hikaye-deniz.webp',
        'gorsel_alt'  => 'Sabah tezgâhta günlük balık',
        'yon'         => 'sag',
        'metrik'      => [
            ['deger' => '04:00', 'etiket' => 'Her sabah tezgâh'],
            ['deger' => '12',    'etiket' => 'Çeşit meze'],
            ['deger' => '3',     'etiket' => 'Şef, tek mutfak'],
        ],
    ],

    [
        'tip'         => 'hikaye',
        'numara'      => '02',
        'ustluk'      => 'Sofra',
        'baslik'      => 'Tabakta ne varsa, mutfakta o var',
        'metin'       => 'Mezeler, ızgaralar ve mevsim balıkları. Şef tabakları haftada bir değişiyor; sabit tariflerimize dokunmuyoruz. Sunum sadeliğini önemsiyoruz — malzeme öne çıksın diye.',
        'gorsel'      => 'hikaye-sofra.webp',
        'gorsel_alt'  => 'Mezeler ve meze tabakları',
        'yon'         => 'sol',
        'buton'       => ['yazi' => 'Menünün tamamı', 'link' => '/menu.php', 'tur' => 'ikincil'],
    ],

    [
        'tip'         => 'sube-onizleme',
        'numara'      => '03',
        'ustluk'      => 'Şubeler',
        'baslik'      => 'Üç kıyı, aynı mutfak',
        'alt_baslik'  => 'İzmir’in üç noktasında; her biri kendi manzarasıyla.',
    ],

    [
        'tip'         => 'kapanis',
        'numara'      => '04',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Bu akşam için bir masa',
        'alt_baslik'  => 'Şube ve bölge seçin, gerisi bizden.',
        'buton_yazi'  => 'Rezervasyon yap',
        'buton_link'  => '/rezervasyon.php',
    ],
];

$sayfalar['menu'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'Menü',
        'baslik'      => 'Sofra',
        'alt_baslik'  => 'Mevsime göre yenilenir. Fiyatlar KDV dâhildir. Alerjileriniz varsa lütfen personelimize bildirin.',
    ],

    [
        'tip'       => 'menu-bolum',
        'numara'    => '01',
        'ad'        => 'Mezeler',
        'aciklama'  => 'Her sabah taze hazırlanır; hiçbir tabak bir gün öncesinden kalmaz.',
        'ogeler'    => [
            ['ad' => 'Humus',            'aciklama' => 'Nohut, tahin, limon, zeytinyağı',           'fiyat' => '180'],
            ['ad' => 'Haydari',          'aciklama' => 'Süzme yoğurt, dereotu, sarımsak',           'fiyat' => '160'],
            ['ad' => 'Ezme',             'aciklama' => 'Ateşte közlenmiş biber ve domates',         'fiyat' => '170'],
            ['ad' => 'Kısır',            'aciklama' => 'İnce bulgur, ekşi nar, taze soğan',         'fiyat' => '170'],
            ['ad' => 'Muhammara',        'aciklama' => 'Ceviz, biber salçası, nar ekşisi',          'fiyat' => '210'],
            ['ad' => 'Fava',             'aciklama' => 'Bakla püresi, dereotu, kırmızı soğan',      'fiyat' => '180'],
            ['ad' => 'Enginar zeytinyağlı','aciklama' => 'Ayvalık zeytinyağında pişirilmiş',        'fiyat' => '220'],
            ['ad' => 'Deniz börülcesi',  'aciklama' => 'Sarımsaklı, limonlu',                       'fiyat' => '200'],
        ],
    ],

    [
        'tip'       => 'menu-bolum',
        'numara'    => '02',
        'ad'        => 'Balık & Deniz Ürünleri',
        'aciklama'  => 'Her sabah İzmir hâlinden. Menü tezgâha göre değişir; sunucularımız günün önerilerini paylaşır.',
        'ogeler'    => [
            ['ad' => 'Levrek',           'aciklama' => 'Kasırga tuzunda fırında',                   'fiyat' => '650'],
            ['ad' => 'Çipura',           'aciklama' => 'Izgara, limon ve rezene',                   'fiyat' => '620'],
            ['ad' => 'Kalamar',          'aciklama' => 'Fırında, sarımsaklı yağda',                 'fiyat' => '480'],
            ['ad' => 'Karides güveç',    'aciklama' => 'Domates, biber, kaşar',                     'fiyat' => '550'],
            ['ad' => 'Ahtapot ızgara',   'aciklama' => 'Kimyon ve limon',                           'fiyat' => '780'],
            ['ad' => 'Somon',            'aciklama' => 'Fesleğenli sos, karnabahar püresi',         'fiyat' => '720'],
            ['ad' => 'Balık çorbası',    'aciklama' => 'Günün taze balığından',                     'fiyat' => '260'],
            ['ad' => 'Midye tava',       'aciklama' => 'Tarator sos ile',                           'fiyat' => '340'],
        ],
    ],

    [
        'tip'       => 'menu-bolum',
        'numara'    => '03',
        'ad'        => 'Izgaralar',
        'aciklama'  => 'Yerli hayvan eti; kömür ateşinde pişirilir.',
        'ogeler'    => [
            ['ad' => 'Kuzu pirzola',     'aciklama' => '4 parça, biberiye',                         'fiyat' => '780'],
            ['ad' => 'Bonfile',          'aciklama' => '200 gr, mantar sos',                        'fiyat' => '850'],
            ['ad' => 'Kaburga',          'aciklama' => 'Yavaş pişmiş, elma püresi',                 'fiyat' => '720'],
            ['ad' => 'Tavuk şiş',        'aciklama' => 'Marine edilmiş, közde',                     'fiyat' => '380'],
        ],
    ],

    [
        'tip'       => 'menu-bolum',
        'numara'    => '04',
        'ad'        => 'Tatlılar',
        'aciklama'  => 'Ev yapımı, mevsim malzemeleriyle.',
        'ogeler'    => [
            ['ad' => 'Sütlaç',           'aciklama' => 'Fırında, tarçınlı',                         'fiyat' => '150'],
            ['ad' => 'Kazandibi',        'aciklama' => 'Klasik reçeteyle',                          'fiyat' => '160'],
            ['ad' => 'Yaz meyveleri',    'aciklama' => 'Mevsime göre — bugün: karpuz & incir',       'fiyat' => '180'],
            ['ad' => 'Künefe',           'aciklama' => 'Antep fıstığı ile',                         'fiyat' => '210'],
        ],
    ],

    [
        'tip'       => 'menu-bolum',
        'numara'    => '05',
        'ad'        => 'İçecekler',
        'aciklama'  => 'Şarap listesi rezervasyonda ayrıca sunulur.',
        'ogeler'    => [
            ['ad' => 'Rakı (35 cl)',     'aciklama' => 'Yeni Rakı / Efe',                           'fiyat' => '320'],
            ['ad' => 'Şarap (kadeh)',    'aciklama' => 'Ev şarabı, kırmızı veya beyaz',             'fiyat' => '180'],
            ['ad' => 'Bira',             'aciklama' => 'Yerli / ithal',                             'fiyat' => '120'],
            ['ad' => 'Ayran',            'aciklama' => 'Çırpma',                                    'fiyat' => '60'],
            ['ad' => 'Türk kahvesi',     'aciklama' => 'Sade / orta / şekerli',                     'fiyat' => '90'],
            ['ad' => 'Filtre kahve',     'aciklama' => 'Tek çeşit ekim değirmen',                   'fiyat' => '100'],
            ['ad' => 'Çay',              'aciklama' => 'Rize',                                      'fiyat' => '30'],
        ],
    ],

    [
        'tip'         => 'kapanis',
        'numara'      => '06',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Menü mevsime göre değişir',
        'alt_baslik'  => 'Bu akşam tezgâhta ne var, rezervasyonla en iyi öğreniriz.',
        'buton_yazi'  => 'Rezervasyon yap',
        'buton_link'  => '/rezervasyon.php',
    ],
];

$sayfalar['iletisim'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'İletişim',
        'baslik'      => 'Yazın, arayın, uğrayın',
        'alt_baslik'  => 'Rezervasyon dışındaki konular için form bize hızlıca ulaşmanın yolu. Mesajlar mesai saatinde yanıtlanır.',
    ],

    [
        'tip' => 'iletisim-form',
        // deger / hatalar / basari / csrf → iletisim.php POST handler tarafından enjekte edilir
    ],

    [
        'tip'         => 'sube-onizleme',
        'ustluk'      => 'Şubeler',
        'baslik'      => 'Üç noktada bekliyoruz',
        'alt_baslik'  => 'Uğramak istiyorsanız — hangi şube olursa olsun, aynı sofra.',
    ],
];

$sayfalar['hizmetler'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'Hizmetler',
        'baslik'      => 'Sofrayı size taşırız',
        'alt_baslik'  => 'Kurumsal davetten düğüne, catering’ten özel menüye — aynı mutfak, size özel plan.',
    ],

    [
        'tip'    => 'hizmet-serit',
        'ogeler' => [
            ['ikon' => 'takim', 'ad' => 'Kurumsal davet', 'metin' => '10–200 kişi, üç şubede özel salon veya tam mekân.'],
            ['ikon' => 'yuzuk', 'ad' => 'Düğün',          'metin' => 'Deniz kenarında; şef menüsü veya açık büfe.'],
            ['ikon' => 'kutu',  'ad' => 'Catering',       'metin' => 'İzmir içi teslim; sıcaklık zinciri korunur.'],
            ['ikon' => 'kalem', 'ad' => 'Özel menü',      'metin' => 'Doğum günü ve kutlamalar için şef masası.'],
        ],
    ],

    [
        'tip'         => 'hikaye',
        'numara'      => '01',
        'ustluk'      => 'Kurumsal davet',
        'baslik'      => 'İş yemekleri ve toplu davetler',
        'metin'       => 'Şubelerimizde 10 ila 200 kişilik davetler için ayrı salon veya tam mekân kiralama. Servis akışını sizinle önden planlarız; yemek zamanlaması ajandanızla uyumlu olur.',
        'gorsel'      => 'hizmet-kurumsal.webp',
        'gorsel_alt'  => 'Kurumsal davet masası',
        'yon'         => 'sag',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '02',
        'ustluk'      => 'Düğün',
        'baslik'      => 'Deniz manzaralı düğünler',
        'metin'       => 'Çeşme ve Karşıyaka şubelerimizin sahil alanlarında 40 ila 250 kişilik düğün organizasyonu. Menü, düğün stiline göre birlikte kurgulanır — açık büfe, servis, cocktail.',
        'gorsel'      => 'hizmet-dugun.webp',
        'gorsel_alt'  => 'Düğün servisi',
        'yon'         => 'sol',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '03',
        'ustluk'      => 'Catering',
        'baslik'      => 'Ofise, eve, mekâna teslim',
        'metin'       => 'İzmir içinde catering servisi. Mezeler, ana yemek ve tatlı — sıcaklık zinciri korunarak dağıtılır. Minimum 20 kişilik siparişten başlar; 48 saat önceden planlanır.',
        'gorsel'      => 'hizmet-catering.webp',
        'gorsel_alt'  => 'Catering paketleri',
        'yon'         => 'sag',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '04',
        'ustluk'      => 'Özel menü',
        'baslik'      => 'Şefin size özel tabağı',
        'metin'       => 'Doğum günü, kutlama, yıldönümü için özel menü. Baş şef ile 15 dakikalık ön görüşmede tercihlerinizi konuşuruz; menü tam olarak size özel kurgulanır.',
        'gorsel'      => 'hizmet-ozel.webp',
        'gorsel_alt'  => 'Şef tabağı',
        'yon'         => 'sol',
    ],

    [
        'tip'     => 'surec',
        'ustluk'  => 'Süreç',
        'baslik'  => 'Dört adımda organize ederiz',
        'adimlar' => [
            ['numara' => '01', 'baslik' => 'İletişim',     'metin' => 'Detayları paylaşırsınız — kişi sayısı, tarih, mekân tercihi.'],
            ['numara' => '02', 'baslik' => 'Ön görüşme',   'metin' => 'Menü tercihleri ve bütçe için 15 dakikalık toplantı.'],
            ['numara' => '03', 'baslik' => 'Teklif',       'metin' => '24 saat içinde detaylı teklif sizinle paylaşılır.'],
            ['numara' => '04', 'baslik' => 'Uygulama',     'metin' => 'Onay sonrası ekip devreye girer; siz gününüzü yaşarsınız.'],
        ],
    ],

    [
        'tip'         => 'kapanis',
        'ustluk'      => 'Teklif iste',
        'baslik'      => 'Etkinliğinizi konuşalım',
        'alt_baslik'  => 'Kısa bir bilgiyle biz size dönelim.',
        'buton_yazi'  => 'İletişime geç',
        'buton_link'  => '/iletisim.php',
    ],
];

$sayfalar['kurumsal'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'Kurumsal',
        'baslik'      => 'Hikâyemiz',
        'alt_baslik'  => '1998’den bu yana, İzmir’in üç kıyısında tek mutfak.',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '01',
        'ustluk'      => 'Başlangıç',
        'baslik'      => 'Alsancak’ta 12 masa',
        'metin'       => 'İlk şubemiz Kordon’un henüz yaya olmadığı yıllarda açıldı. Amaç basitti: İzmir hâlinden çıkan balığı, aynı gün sofraya taşımak. Menü o günden bugüne çok değişmedi; asıl değişen, tanıdık simaların çoğalması.',
        'gorsel'      => 'kurumsal-baslangic.webp',
        'gorsel_alt'  => 'Alsancak, ilk günlerden bir kare',
        'yon'         => 'sag',
    ],
    [
        'tip'    => 'alinti',
        'metin'  => 'Balık akşamdan sabaha bekleyecek kadar taze olmaz. Ne alırsak, gün içinde pişireceğimizden emin oluruz.',
        'kaynak' => 'Baş şef, kurucu ortak',
    ],
    [
        'tip'         => 'hikaye',
        'numara'      => '02',
        'ustluk'      => 'Büyüme',
        'baslik'      => 'Üç şubeye, tek mutfağa',
        'metin'       => 'Çeşme ikinci; Karşıyaka üçüncü. Her yeni şubede aynı şef kadrosuyla açılış yaptık; ilk üç ay iki mutfak birlikte çalıştı ki tarifler aynı kalsın. Bugün şubeler arası fark yalnızca ambiyansta.',
        'gorsel'      => 'kurumsal-buyume.webp',
        'gorsel_alt'  => 'Mutfakta ortak hazırlık',
        'yon'         => 'sol',
    ],
    [
        'tip'    => 'zaman-cizelgesi',
        'ustluk' => 'Zaman çizelgesi',
        'baslik' => 'Sofraya götüren tarihler',
        'ogeler' => [
            ['yil' => '1998', 'olay' => 'Alsancak şubesi açılışı — 12 masa, tek şef.'],
            ['yil' => '2003', 'olay' => 'Menüye deniz börülcesi ve Ege usulü zeytinyağlı meze girişi.'],
            ['yil' => '2005', 'olay' => 'Çeşme, Ilıca sahilinde ikinci şube.'],
            ['yil' => '2010', 'olay' => '“Zeytinden Sofraya” tarif kitabımız — yerel yayınevi.'],
            ['yil' => '2015', 'olay' => 'Karşıyaka Bostanlı üçüncü şube — en büyük mekânımız.'],
            ['yil' => '2020', 'olay' => 'Pandemi döneminde paket servis ve tarif kartları.'],
            ['yil' => '2024', 'olay' => 'Doğrudan tedarik programı — Foça ve Alaçatı balıkçılarıyla.'],
        ],
    ],
    [
        'tip'    => 'degerler',
        'ustluk' => 'İlkelerimiz',
        'baslik' => 'Dört basit kural',
        'ogeler' => [
            ['ikon' => 'balik',  'baslik' => 'Aynı gün balık',   'metin' => 'Sabah hâlden gelmeyen balığı sofraya koymayız.'],
            ['ikon' => 'terazi', 'baslik' => 'Aynı tarif',       'metin' => 'Şubeler arası fark yok — humus üç yerde aynı.'],
            ['ikon' => 'yaprak', 'baslik' => 'Mevsimden yana',   'metin' => 'Menü mevsime göre yenilenir; iddialı liste değil.'],
            ['ikon' => 'el',     'baslik' => 'Elden yapılır',    'metin' => 'Meze, sos ve tatlı — hazır alım yok.'],
        ],
    ],
    [
        'tip'         => 'kapanis',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Sofrada buluşalım',
        'alt_baslik'  => 'Hangi şube olursa olsun.',
        'buton_yazi'  => 'Rezervasyon yap',
        'buton_link'  => '/rezervasyon.php',
    ],
];

$sayfalar['galeri'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'Galeri',
        'baslik'      => 'Sofradan sahneler',
        'alt_baslik'  => 'Mutfaktan, salondan, terastan; günün ışığında ve akşamın ışığında.',
    ],

    [
        'tip'    => 'galeri-izgara',
        'ogeler' => [
            ['dosya' => 'galeri-01.webp', 'kategori' => 'yemek',    'alt' => 'Levrek fırında',           'altyazi' => 'Levrek — kasırga tuzunda fırında'],
            ['dosya' => 'galeri-02.webp', 'kategori' => 'mekan',    'alt' => 'Alsancak terası akşam',    'altyazi' => 'Alsancak · akşam servisi'],
            ['dosya' => 'galeri-03.webp', 'kategori' => 'yemek',    'alt' => 'Meze tabakları',           'altyazi' => 'Meze — sabah hazırlığı'],
            ['dosya' => 'galeri-04.webp', 'kategori' => 'etkinlik', 'alt' => 'Kurumsal davet',           'altyazi' => 'Kurumsal davet · 40 kişi'],
            ['dosya' => 'galeri-05.webp', 'kategori' => 'yemek',    'alt' => 'Karides güveç',            'altyazi' => 'Karides güveç'],
            ['dosya' => 'galeri-06.webp', 'kategori' => 'mekan',    'alt' => 'Çeşme sahil terası',       'altyazi' => 'Çeşme · iskele yanı'],
            ['dosya' => 'galeri-07.webp', 'kategori' => 'yemek',    'alt' => 'Kalamar fırında',          'altyazi' => 'Kalamar — sarımsaklı yağ'],
            ['dosya' => 'galeri-08.webp', 'kategori' => 'etkinlik', 'alt' => 'Şef masası',               'altyazi' => 'Şef masası · özel gece'],
            ['dosya' => 'galeri-09.webp', 'kategori' => 'mekan',    'alt' => 'Karşıyaka bahçe',          'altyazi' => 'Karşıyaka · çim bahçe'],
            ['dosya' => 'galeri-10.webp', 'kategori' => 'yemek',    'alt' => 'Ahtapot ızgara',           'altyazi' => 'Ahtapot ızgara'],
            ['dosya' => 'galeri-11.webp', 'kategori' => 'mekan',    'alt' => 'İç salon Alsancak',        'altyazi' => 'İç salon · Alsancak'],
            ['dosya' => 'galeri-12.webp', 'kategori' => 'yemek',    'alt' => 'Balık çorbası',            'altyazi' => 'Balık çorbası'],
            ['dosya' => 'galeri-13.webp', 'kategori' => 'etkinlik', 'alt' => 'Düğün masaları',           'altyazi' => 'Düğün · 80 kişi'],
            ['dosya' => 'galeri-14.webp', 'kategori' => 'mekan',    'alt' => 'Kordon manzarası',         'altyazi' => 'Kordon manzarası · gün batımı'],
            ['dosya' => 'galeri-15.webp', 'kategori' => 'yemek',    'alt' => 'Tatlı tabağı',             'altyazi' => 'Tatlı — mevsim meyveleri'],
        ],
    ],

    [
        'tip'         => 'kapanis',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Bir sonraki sahnede sizin masanız',
        'alt_baslik'  => 'Şube ve bölge seçin, tarih girin.',
        'buton_yazi'  => 'Rezervasyon yap',
        'buton_link'  => '/rezervasyon.php',
    ],
];

$sayfalar['subeler'] = [
    [
        'tip'         => 'sayfa-baslik',
        'ustluk'      => 'Şubeler',
        'baslik'      => 'Üç kıyı, aynı mutfak',
        'alt_baslik'  => 'İzmir’in üç noktasında; her biri kendi manzarası, aynı sofra. Tarifler değişmez, ambiyans değişir.',
    ],
    [
        'tip'    => 'sube-detay',
        'slug'   => 'alsancak',
        'numara' => '01',
        'yon'    => 'sag',
        'metin'  => 'Kordon’un tam ortası. Öğle servisi işten çıkanlarla, akşam yürüyüşten dönenlerle dolar. İç mekân yüksek tavanlı; teras panoramik.',
    ],
    [
        'tip'    => 'sube-detay',
        'slug'   => 'cesme',
        'numara' => '02',
        'yon'    => 'sol',
        'metin'  => 'Ilıca sahilinde, iskeleye açılan platform. Yaz aylarında rezervasyon zorunlu; balık, denizden on metre uzakta pişer.',
    ],
    [
        'tip'    => 'sube-detay',
        'slug'   => 'karsiyaka',
        'numara' => '03',
        'yon'    => 'sag',
        'metin'  => 'Bostanlı sahil bulvarında; en büyük şubemiz. Aile grupları için tercih; çim bahçesi çocuklara özel.',
    ],
    [
        'tip'         => 'kapanis',
        'numara'      => '04',
        'ustluk'      => 'Rezervasyon',
        'baslik'      => 'Hangisine gelirseniz, aynı sofra',
        'alt_baslik'  => 'Şube ve bölge seçin, tarih girin. Onay için sizi arayacağız.',
        'buton_yazi'  => 'Rezervasyon yap',
        'buton_link'  => '/rezervasyon.php',
    ],
];
