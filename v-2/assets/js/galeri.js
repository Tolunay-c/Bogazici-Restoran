/* ==============================================================
   galeri.js — kategori filtresi + <dialog> lightbox
   ============================================================== */
(function () {
  'use strict';

  var sayfa = document.querySelector('[data-galeri]');
  if (!sayfa) return;

  var filtreBtn = sayfa.querySelectorAll('.galeri-filtre__btn');
  var ogeler    = sayfa.querySelectorAll('.galeri-oge');
  var sayac     = sayfa.querySelector('[data-galeri-sayac]');

  /* --- Kategori filtresi ----------------------------------- */
  function filtrele(kategori) {
    filtreBtn.forEach(function (b) {
      b.setAttribute('aria-pressed', b.dataset.kategori === kategori ? 'true' : 'false');
    });

    var gorunur = 0;
    ogeler.forEach(function (o) {
      var eslesir = (kategori === 'tumu') || (o.dataset.kategori === kategori);
      o.hidden = !eslesir;
      if (eslesir) gorunur++;
    });

    if (sayac) sayac.textContent = gorunur + ' görsel';
  }

  filtreBtn.forEach(function (btn) {
    btn.addEventListener('click', function () { filtrele(btn.dataset.kategori); });
  });

  // İlk sayaç
  filtrele('tumu');

  /* --- Lightbox <dialog> ----------------------------------- */
  var kutu       = document.getElementById('lightbox');
  var kutuImg    = kutu ? kutu.querySelector('[data-lightbox-img]') : null;
  var kutuAlt    = kutu ? kutu.querySelector('[data-lightbox-altyazi]') : null;
  var kutuKapat  = kutu ? kutu.querySelector('[data-lightbox-kapat]') : null;
  var sonTetik   = null;

  if (kutu && kutuImg) {
    sayfa.addEventListener('click', function (ev) {
      var tetik = ev.target.closest('[data-lightbox]');
      if (!tetik) return;
      sonTetik = tetik;
      kutuImg.src = tetik.dataset.lightbox;
      kutuImg.alt = tetik.getAttribute('aria-label') || '';
      if (kutuAlt) kutuAlt.textContent = tetik.dataset.altyazi || '';
      kutu.showModal();
    });

    if (kutuKapat) kutuKapat.addEventListener('click', function () { kutu.close(); });

    // Backdrop tıklaması ile kapat
    kutu.addEventListener('click', function (ev) {
      if (ev.target === kutu) kutu.close();
    });

    kutu.addEventListener('close', function () {
      if (kutuImg) kutuImg.src = '';
      if (sonTetik) sonTetik.focus();
    });
  }
})();
