/* ==============================================================
   app.js — vanilla, bağımlılık yok
   ============================================================== */
(function () {
  'use strict';

  var azHareket = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var masaustu  = window.matchMedia('(min-width: 900px)');

  /* --- Mobil çekmece ------------------------------------------ */
  var cekmece = document.getElementById('cekmece');
  var acButon = document.querySelector('[data-cekmece-ac]');

  if (cekmece && acButon) {
    var kaydirma = 0;

    function ac() {
      kaydirma = window.scrollY;
      cekmece.showModal();
      acButon.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    }

    function kapat() {
      if (cekmece.open) cekmece.close();
    }

    cekmece.addEventListener('close', function () {
      acButon.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      window.scrollTo(0, kaydirma);
      acButon.focus();
    });

    acButon.addEventListener('click', ac);
    cekmece.querySelectorAll('[data-cekmece-kapat], a').forEach(function (el) {
      el.addEventListener('click', kapat);
    });

    // Masaüstüne genişlerse açık kalmasın
    masaustu.addEventListener('change', function (e) {
      if (e.matches) kapat();
    });
  }

  /* --- Galeri lightbox ---------------------------------------- */
  var kutu = document.getElementById('lightbox');
  if (kutu) {
    var kutuGorsel = kutu.querySelector('img');
    var sonTetik = null;

    document.addEventListener('click', function (ev) {
      var tetik = ev.target.closest('[data-lightbox]');
      if (!tetik) return;
      sonTetik = tetik;
      kutuGorsel.src = tetik.getAttribute('data-lightbox');
      kutuGorsel.alt = tetik.getAttribute('aria-label') || '';
      kutu.showModal();
    });

    kutu.addEventListener('click', function (ev) {
      if (ev.target === kutu || ev.target.closest('[data-lightbox-kapat]')) kutu.close();
    });

    kutu.addEventListener('close', function () {
      kutuGorsel.removeAttribute('src');
      if (sonTetik) sonTetik.focus();
    });
  }

  /* --- SSS: ilk soru yalnızca masaüstünde açık ----------------- */
  function sssAyarla() {
    document.querySelectorAll('[data-mobilde-kapali]').forEach(function (d) {
      if (!masaustu.matches) d.removeAttribute('open');
    });
  }
  sssAyarla();
  masaustu.addEventListener('change', sssAyarla);


  /* --- Galeri masonry ------------------------------------------
     Eşit genişlikte 5/4/3/2 kolon. Her öğe o an EN ALÇAK kolona
     oturur — columns'tan farkı bu: kolon dipleri dengelenir ve
     okuma sırası soldan sağa olur.
     ------------------------------------------------------------ */
  function galeriKur(kap) {
    var ogeler = Array.prototype.slice.call(kap.children);
    if (!ogeler.length) return;

    function oran(oge) {
      var img = oge.querySelector('img');
      if (!img) return 3 / 2;
      var e = img.naturalWidth || parseFloat(img.getAttribute('width')) || 3;
      var b = img.naturalHeight || parseFloat(img.getAttribute('height')) || 2;
      return e / b;
    }

    function yerlestir() {
      // ÖNEMLİ: ölçümden önce mutlak yerleşime geç. Yedek ızgarada
      // görseller doğal genişlikte durduğu için kapsayıcı taşmış
      // oluyor ve clientWidth yanlış (taşmış) değeri veriyor.
      kap.classList.add('gallery--ready');
      kap.style.height = '';
      var w = kap.clientWidth;
      if (!w) return;

      var stil = getComputedStyle(kap);
      var oluk = parseFloat(stil.getPropertyValue('--galeri-oluk')) || 20;
      var birimSayisi = w >= 1200 ? 5 : (w >= 900 ? 4 : (w >= 600 ? 3 : 2));
      var birim = (w - oluk * (birimSayisi - 1)) / birimSayisi;
      var kolonY = [];
      for (var i = 0; i < birimSayisi; i++) kolonY.push(0);

      ogeler.forEach(function (oge) {
        var o = oran(oge);
        // Eşit genişlik. Genişlik varyasyonu dokuyu delik deşik ediyor;
        // yoğunluk kolon sayısı + dar oluk + fotoğraf adedinden gelir.
        var kapla = 1;

        // Bu genişlikte oturabileceği en yüksek (en alçak y) yer
        var enIyi = 0, enIyiY = Infinity;
        for (var s = 0; s + kapla <= birimSayisi; s++) {
          var y = 0;
          for (var k = s; k < s + kapla; k++) if (kolonY[k] > y) y = kolonY[k];
          if (y < enIyiY - 0.5) { enIyiY = y; enIyi = s; }
        }

        var genislik = kapla * birim + (kapla - 1) * oluk;
        var yukseklik = genislik / o;

        oge.style.width = genislik + 'px';
        oge.style.transform = 'translate(' + (enIyi * (birim + oluk)) + 'px,' + enIyiY + 'px)';

        for (var k2 = enIyi; k2 < enIyi + kapla; k2++) kolonY[k2] = enIyiY + yukseklik + oluk;
      });

      // data-kirp: yükseklik EN KISA kolona göre ayarlanır, taşan kısım
      // kırpılır. Masonry'de tırtıklı alt kenarın tek gerçek çözümü bu.
      var enAlt = 0, enKisa = Infinity;
      kolonY.forEach(function (y) {
        if (y > enAlt) enAlt = y;
        if (y < enKisa) enKisa = y;
      });
      var hedef = kap.hasAttribute('data-kirp') ? enKisa : enAlt;
      kap.style.height = Math.max(0, hedef - oluk) + 'px';
    }

    yerlestir();

    // Görseller indikçe gerçek oranla tekrar hesapla
    kap.querySelectorAll('img').forEach(function (img) {
      if (!img.complete) img.addEventListener('load', yerlestir, { once: true });
    });

    var zamanlayici;
    var gozlemci = new ResizeObserver(function () {
      clearTimeout(zamanlayici);
      zamanlayici = setTimeout(yerlestir, 80);
    });
    gozlemci.observe(kap);
  }

  document.querySelectorAll('[data-masonry]').forEach(galeriKur);



  /* --- Harita (Leaflet) ----------------------------------------
     Anahtar gerektirmeyen OpenStreetMap karoları. Leaflet defer ile
     yüklendiği için hazır olmasını bekliyoruz; yoksa alan boş kalır
     ama sayfa çalışmaya devam eder.
     ------------------------------------------------------------ */
  var HARITA_KAROSU = 'https://api.maptiler.com/maps/dataviz/{z}/{x}/{y}{r}.png?key=xq1fgVVFhTHrdVSQ6lwc';
  var HARITA_ATIF = '&copy; <a href="https://www.maptiler.com/copyright/" target="_blank" rel="noopener">MapTiler</a> &copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> katkıcıları';

  function haritaIsaretIkonu() {
    return L.divIcon({
      className: 'map__marker-box',
      html: '<span class="map__marker">' +
              '<span class="map__marker-ring"></span>' +
              '<span class="map__marker-ring map__marker-ring--delayed"></span>' +
              '<span class="map__marker-dot"></span>' +
            '</span>',
      iconSize: [22, 22],
      iconAnchor: [11, 11],
      popupAnchor: [0, -14]
    });
  }

  function haritaKur(el) {
    var enlem = parseFloat(el.getAttribute('data-enlem'));
    var boylam = parseFloat(el.getAttribute('data-boylam'));
    if (isNaN(enlem) || isNaN(boylam)) return;

    var harita = L.map(el, {
      center: [enlem, boylam],
      zoom: 15,
      scrollWheelZoom: false,        // sayfa kaydırırken harita zoom yapmasın
      zoomControl: false,            // kart içinde kontrol gürültü yapıyor
      attributionControl: true
    });

    L.tileLayer(HARITA_KAROSU, {
      maxZoom: 20,
      tileSize: 512,
      zoomOffset: -1,
      crossOrigin: true,
      attribution: HARITA_ATIF
    }).addTo(harita);

    L.marker([enlem, boylam], {
      icon: haritaIsaretIkonu(),
      title: el.getAttribute('data-ad') || '',
      alt: el.getAttribute('data-ad') || ''
    }).addTo(harita)
      .bindPopup('<strong>' + (el.getAttribute('data-ad') || '') + '</strong><br>' +
                 (el.getAttribute('data-adres') || ''));

    // Tıklayınca tekerlek zoom'u açılsın — kaza ile zoom olmaz
    harita.on('click', function () { harita.scrollWheelZoom.enable(); });
    harita.on('mouseout', function () { harita.scrollWheelZoom.disable(); });
  }

  var haritalar = document.querySelectorAll('[data-harita]');
  if (haritalar.length) {
    var bekle = setInterval(function () {
      if (typeof L === 'undefined') return;
      clearInterval(bekle);
      haritalar.forEach(haritaKur);
    }, 60);
    setTimeout(function () { clearInterval(bekle); }, 8000);
  }

  /* --- Harita (sekmeli, tek harita) — iletişim sayfası ----------
     Şube sekmesine basınca aynı harita yeni konuma kayar; ayrı bir
     Leaflet örneği açmaz. ------------------------------------- */
  function haritaSekmeliKur(kok) {
    var tuval = kok.querySelector('[data-harita-sekmeli-tuval]');
    if (!tuval) return;

    var enlem = parseFloat(tuval.getAttribute('data-enlem'));
    var boylam = parseFloat(tuval.getAttribute('data-boylam'));
    if (isNaN(enlem) || isNaN(boylam)) return;

    var harita = L.map(tuval, {
      center: [enlem, boylam],
      zoom: 15,
      scrollWheelZoom: false,
      zoomControl: false,
      attributionControl: true
    });

    L.tileLayer(HARITA_KAROSU, {
      maxZoom: 20,
      tileSize: 512,
      zoomOffset: -1,
      crossOrigin: true,
      attribution: HARITA_ATIF
    }).addTo(harita);

    var isaret = L.marker([enlem, boylam], {
      icon: haritaIsaretIkonu(),
      title: tuval.getAttribute('data-ad') || ''
    }).addTo(harita);

    harita.on('click', function () { harita.scrollWheelZoom.enable(); });
    harita.on('mouseout', function () { harita.scrollWheelZoom.disable(); });

    var sekmeler = kok.parentElement.querySelectorAll('.map-tabs__tab');
    var link = kok.querySelector('[data-harita-sekmeli-link]');
    var adEl = kok.querySelector('[data-harita-sekmeli-ad]');
    var adresEl = kok.querySelector('[data-harita-sekmeli-adres]');

    sekmeler.forEach(function (sekme) {
      sekme.addEventListener('click', function () {
        var e = parseFloat(sekme.getAttribute('data-enlem'));
        var b = parseFloat(sekme.getAttribute('data-boylam'));
        if (isNaN(e) || isNaN(b)) return;

        sekmeler.forEach(function (s) {
          s.classList.remove('map-tabs__tab--active');
          s.setAttribute('aria-selected', 'false');
        });
        sekme.classList.add('map-tabs__tab--active');
        sekme.setAttribute('aria-selected', 'true');

        harita.setView([e, b], 15);
        isaret.setLatLng([e, b]);
        isaret.setIcon(haritaIsaretIkonu());
        tuval.setAttribute('aria-label', (sekme.getAttribute('data-ad') || '') + ' şubesi konumu haritada');

        if (adEl) adEl.textContent = sekme.getAttribute('data-ad') || '';
        if (adresEl) adresEl.textContent = sekme.getAttribute('data-adres') || '';
        if (link) link.setAttribute('href', sekme.getAttribute('data-yol-tarifi') || '#');

        setTimeout(function () { harita.invalidateSize(); }, 50);
      });
    });
  }

  var haritaSekmeliKoklari = document.querySelectorAll('[data-harita-sekmeli]');
  if (haritaSekmeliKoklari.length) {
    var bekleSekmeli = setInterval(function () {
      if (typeof L === 'undefined') return;
      clearInterval(bekleSekmeli);
      haritaSekmeliKoklari.forEach(haritaSekmeliKur);
    }, 60);
    setTimeout(function () { clearInterval(bekleSekmeli); }, 8000);
  }

  /* --- Sayaç ---------------------------------------------------
     "40+" gibi değerlerde yalnızca sayı kısmı sayılır, ön/son ek
     korunur. Reduced-motion'da doğrudan son değer yazılır.
     ------------------------------------------------------------ */
  function sayacKur(el) {
    var ham = el.textContent.trim();
    var parca = ham.match(/^(\D*)(\d+)(.*)$/);
    if (!parca) return;

    var on = parca[1], hedef = parseInt(parca[2], 10), son = parca[3];
    if (azHareket) return;

    el.textContent = on + '0' + son;
    var sure = 1100, basla = null;

    function adim(t) {
      if (basla === null) basla = t;
      var ilerleme = Math.min(1, (t - basla) / sure);
      var yumusak = 1 - Math.pow(1 - ilerleme, 3);
      el.textContent = on + Math.round(hedef * yumusak) + son;
      if (ilerleme < 1) requestAnimationFrame(adim);
    }
    requestAnimationFrame(adim);
  }

  var sayaclar = document.querySelectorAll('[data-sayac]');
  if (sayaclar.length && 'IntersectionObserver' in window) {
    var sayacGozlemci = new IntersectionObserver(function (girisler) {
      girisler.forEach(function (g) {
        if (!g.isIntersecting) return;
        sayacKur(g.target);
        sayacGozlemci.unobserve(g.target);
      });
    }, { threshold: 0.4 });
    sayaclar.forEach(function (el) { sayacGozlemci.observe(el); });
  }

  /* --- Rezervasyon: şube tab + bölge seçim + kroki/liste -------
     v-2 MASTER §7.1 spec, v-1 token'larıyla. Roving tabindex,
     ArrowLeft/Right; şube değişince form sıfırlanır;
     bölge seçilince aria-live duyurusu + form kilit açılır. */
  var rez = document.querySelector('.reservation');
  if (rez) {
    var sekmeler = Array.prototype.slice.call(rez.querySelectorAll('.reservation__tab'));
    var paneller = Array.prototype.slice.call(rez.querySelectorAll('.reservation__panel'));
    var form     = rez.querySelector('.reservation__form');
    var duyuru   = rez.querySelector('[data-duyuru]');
    var secimAd  = rez.querySelector('[data-secim-ad]');
    var secimIp  = rez.querySelector('[data-secim-ipucu]');
    var seciliSube  = rez.querySelector('[data-secili-sube]');
    var seciliBolge = rez.querySelector('[data-secili-bolge]');

    function panelGoster(slug) {
      paneller.forEach(function (p) {
        var aktif = p.getAttribute('data-sube') === slug;
        if (aktif) p.removeAttribute('hidden'); else p.setAttribute('hidden', '');
      });
    }

    function subeSec(slug) {
      sekmeler.forEach(function (s) {
        var aktif = s.getAttribute('data-sube') === slug;
        s.setAttribute('aria-selected', aktif ? 'true' : 'false');
        s.setAttribute('tabindex', aktif ? '0' : '-1');
        s.classList.toggle('reservation__tab--selected', aktif);
      });
      panelGoster(slug);
      seciliSube.value = slug;
      bolgeSifirla();
    }

    function bolgeSifirla() {
      if (!seciliBolge) return; // kroki/liste kaldırıldı — bölge seçimi yok
      seciliBolge.value = '';
      form.setAttribute('data-hazir', 'false');
      if (secimAd) secimAd.textContent = '— henüz seçilmedi —';
      if (secimIp) secimIp.textContent = 'Devam etmek için bir bölge seçin.';
      rez.querySelectorAll('[aria-pressed="true"]').forEach(function (el) {
        el.setAttribute('aria-pressed', 'false');
      });
    }

    function bolgeSec(tetik) {
      if (tetik.getAttribute('aria-disabled') === 'true' || tetik.disabled) return;
      var id     = tetik.getAttribute('data-bolge-id');
      var ad     = tetik.getAttribute('data-bolge-ad');
      var musait = tetik.getAttribute('data-bolge-musait');
      var panel  = tetik.closest('.reservation__panel');
      if (!panel) return;

      panel.querySelectorAll('[data-bolge-id]').forEach(function (el) {
        el.setAttribute('aria-pressed', el.getAttribute('data-bolge-id') === id ? 'true' : 'false');
      });

      seciliBolge.value = id;
      form.setAttribute('data-hazir', 'true');
      secimAd.textContent = ad;
      secimIp.textContent = musait + ' masa müsait — bilgilerinizi girip onaylayın.';
      // aria-live duyurusu için içerik değişikliği yeterli
    }

    // Tab click + klavye
    sekmeler.forEach(function (s, i) {
      s.addEventListener('click', function () { subeSec(s.getAttribute('data-sube')); s.focus(); });
      s.addEventListener('keydown', function (ev) {
        var yon = ev.key === 'ArrowRight' ? 1 : (ev.key === 'ArrowLeft' ? -1 : 0);
        if (!yon) return;
        ev.preventDefault();
        var yeni = sekmeler[(i + yon + sekmeler.length) % sekmeler.length];
        subeSec(yeni.getAttribute('data-sube'));
        yeni.focus();
      });
    });

    // Bölge tıklama + klavye (SVG g + liste button)
    rez.addEventListener('click', function (ev) {
      var t = ev.target.closest('[data-bolge-id]');
      if (t && rez.contains(t)) bolgeSec(t);
    });
    rez.addEventListener('keydown', function (ev) {
      if (ev.key !== 'Enter' && ev.key !== ' ') return;
      var t = ev.target.closest('[data-bolge-id]');
      if (!t) return;
      ev.preventDefault();
      bolgeSec(t);
    });

    // Kroki / Liste toggle
    rez.querySelectorAll('.reservation__view').forEach(function (grup) {
      var btnlar = Array.prototype.slice.call(grup.querySelectorAll('.reservation__view-btn'));
      btnlar.forEach(function (b) {
        b.addEventListener('click', function () {
          var mod = b.getAttribute('data-gorunum');
          var panel = b.closest('.reservation__panel');
          btnlar.forEach(function (x) {
            var aktif = x === b;
            x.setAttribute('aria-selected', aktif ? 'true' : 'false');
            x.classList.toggle('reservation__view-btn--selected', aktif);
          });
          panel.querySelectorAll('[data-gorunum-panel]').forEach(function (p) {
            if (p.getAttribute('data-gorunum-panel') === mod) p.removeAttribute('hidden');
            else p.setAttribute('hidden', '');
          });
        });
      });
    });

    // Kişi sayacı
    var kisi = rez.querySelector('#rez-kisi');
    var eksi = rez.querySelector('[data-sayac-eksi]');
    var arti = rez.querySelector('[data-sayac-arti]');
    if (kisi && eksi && arti) {
      function guncelle(delta) {
        var v = parseInt(kisi.value, 10) || 2;
        v = Math.max(1, Math.min(12, v + delta));
        kisi.value = v;
      }
      eksi.addEventListener('click', function () { guncelle(-1); });
      arti.addEventListener('click', function () { guncelle(1); });
    }

    // Nefes hint (§5.3): açılışta aktif panelde 2 döngü
    if (!azHareket) {
      var aktifPanel = rez.querySelector('.reservation__panel:not([hidden])');
      if (aktifPanel) {
        aktifPanel.setAttribute('data-nefes', '1');
        setTimeout(function () { aktifPanel.removeAttribute('data-nefes'); }, 3600);
      }
    }
  }

  /* --- Scroll reveal: tek tip, stagger yok --------------------- */
  var hedefler = document.querySelectorAll('[data-goster]');
  if (azHareket || !('IntersectionObserver' in window)) {
    hedefler.forEach(function (el) { el.setAttribute('data-goster', 'acik'); });
  } else {
    var gozlemci = new IntersectionObserver(function (girisler) {
      girisler.forEach(function (g) {
        if (!g.isIntersecting) return;
        g.target.setAttribute('data-goster', 'acik');
        gozlemci.unobserve(g.target);
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.1 });

    hedefler.forEach(function (el) { gozlemci.observe(el); });
  }
})();
