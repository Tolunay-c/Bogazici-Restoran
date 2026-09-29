/* Boğaziçi — harita.js
 * Leaflet + OpenStreetMap.
 * 1) Tekil haritalar: [data-harita-lat][data-harita-lng] taşıyan her element.
 * 2) Sekmeli tek harita: [data-harita-cok] + .harita-sekmeli__sekme[data-harita-hedef].
 */
(function () {
  'use strict';

  if (typeof L === 'undefined') return;

  var SUBELER = window.BOGAZICI_SUBELER || null;

  function haritaKur(el, lat, lng, etiket) {
    var harita = L.map(el, {
      scrollWheelZoom: false,
      zoomControl: true
    }).setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(harita);

    var m = L.marker([lat, lng]).addTo(harita);
    if (etiket) m.bindPopup(etiket);

    return { harita: harita, marker: m };
  }

  /* 1) Tekil harita — sube-detay içi */
  var tekliler = document.querySelectorAll('[data-harita-lat][data-harita-lng]:not([data-harita-cok])');
  tekliler.forEach(function (el) {
    var lat = parseFloat(el.getAttribute('data-harita-lat'));
    var lng = parseFloat(el.getAttribute('data-harita-lng'));
    var etk = el.getAttribute('data-harita-etiket') || '';
    if (isNaN(lat) || isNaN(lng)) return;
    haritaKur(el, lat, lng, etk);
  });

  /* 2) Sekmeli harita — iletişim */
  var sekmeliler = document.querySelectorAll('[data-harita-cok]');
  sekmeliler.forEach(function (haritaEl) {
    var kok = haritaEl.closest('.harita-sekmeli') || document;
    var sekmeler = kok.querySelectorAll('[data-harita-hedef]');
    if (!sekmeler.length) return;

    var baslangicLat = parseFloat(haritaEl.getAttribute('data-harita-baslangic-lat'));
    var baslangicLng = parseFloat(haritaEl.getAttribute('data-harita-baslangic-lng'));
    if (isNaN(baslangicLat) || isNaN(baslangicLng)) return;

    var kur = haritaKur(haritaEl, baslangicLat, baslangicLng, '');
    var harita = kur.harita;
    var marker = kur.marker;

    /* Sube verisi DOM'dan (paneller data-harita-panel + data-lat/lng) veya global */
    function noktaBul(slug) {
      var panel = kok.querySelector('[data-harita-panel="' + slug + '"]');
      if (!panel) return null;
      var lat = parseFloat(panel.getAttribute('data-lat'));
      var lng = parseFloat(panel.getAttribute('data-lng'));
      var ad  = panel.getAttribute('data-ad') || '';
      if (isNaN(lat) || isNaN(lng)) {
        if (SUBELER && SUBELER[slug]) {
          lat = SUBELER[slug].lat; lng = SUBELER[slug].lng; ad = SUBELER[slug].ad || ad;
        }
      }
      if (isNaN(lat) || isNaN(lng)) return null;
      return { lat: lat, lng: lng, ad: ad };
    }

    function goster(slug) {
      var nokta = noktaBul(slug);
      if (!nokta) return;
      harita.setView([nokta.lat, nokta.lng], 15, { animate: true });
      marker.setLatLng([nokta.lat, nokta.lng]);
      if (nokta.ad) marker.bindPopup(nokta.ad);

      sekmeler.forEach(function (s) {
        var akt = s.getAttribute('data-harita-hedef') === slug;
        s.setAttribute('aria-selected', akt ? 'true' : 'false');
        s.setAttribute('tabindex', akt ? '0' : '-1');
      });
      var paneller = kok.querySelectorAll('[data-harita-panel]');
      paneller.forEach(function (p) {
        p.classList.toggle('aktif', p.getAttribute('data-harita-panel') === slug);
      });

      /* Harita boyutlanma sorunu için invalidateSize */
      setTimeout(function () { harita.invalidateSize(); }, 60);
    }

    sekmeler.forEach(function (s) {
      s.addEventListener('click', function () {
        goster(s.getAttribute('data-harita-hedef'));
      });
      s.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          goster(s.getAttribute('data-harita-hedef'));
        }
      });
    });

    /* İlk yüklemede boyut düzelt */
    setTimeout(function () { harita.invalidateSize(); }, 120);
  });
})();
