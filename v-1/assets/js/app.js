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
      kap.classList.add('galeri--hazir');
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

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap katkıcıları'
    }).addTo(harita);

    var isaret = L.divIcon({
      className: '',
      html: '<span class="harita__isaret">' +
              '<svg viewBox="0 0 26 34" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">' +
                '<path class="pin-govde" d="M13 0C5.8 0 0 5.8 0 13c0 9.1 13 21 13 21s13-11.9 13-21C26 5.8 20.2 0 13 0z"/>' +
                '<circle class="pin-nokta" cx="13" cy="12.5" r="4.6"/>' +
              '</svg>' +
            '</span>',
      iconSize: [26, 34],
      iconAnchor: [13, 34],
      popupAnchor: [0, -30]
    });

    L.marker([enlem, boylam], {
      icon: isaret,
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
