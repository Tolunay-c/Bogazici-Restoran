/* ==============================================================
   app.js — vanilla, bağımlılık yok
   Mobil çekmece + nav shrink
   ============================================================== */
(function () {
  'use strict';

  var masaustu = window.matchMedia('(min-width: 900px)');

  /* --- Mobil çekmece ---------------------------------------- */
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
    function kapat() { if (cekmece.open) cekmece.close(); }

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
    masaustu.addEventListener('change', function (e) { if (e.matches) kapat(); });
  }

  /* --- Nav shrink on scroll --------------------------------- */
  var ust = document.querySelector('.ust');
  if (ust) {
    var esik = 40;
    var son = false;
    function guncelle() {
      var simdi = window.scrollY > esik;
      if (simdi !== son) {
        ust.classList.toggle('ust--daralmis', simdi);
        son = simdi;
      }
    }
    guncelle();
    window.addEventListener('scroll', guncelle, { passive: true });
  }

  /* --- Reveal (GSAP + ScrollTrigger) ------------------------ */
  /* SSR/no-JS: [data-reveal] görünür başlar; JS varsa gizlenip
     kaydırma ile açığa çıkar. Reduced motion -> son hâl, animasyon yok. */
  var azHareket = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var reveals = document.querySelectorAll('[data-reveal]');

  if (window.gsap && window.ScrollTrigger && !azHareket && reveals.length) {
    window.gsap.registerPlugin(window.ScrollTrigger);
    // Kısa bir "flash" pahasına: JS geç yüklendiğinde önce görünür sonra gizlenir.
    // Ama JS yoksa hep görünür — a11y güvenli.
    window.gsap.set(reveals, { opacity: 0, y: 24 });

    window.ScrollTrigger.matchMedia({
      // Masaüstü + tablet
      '(min-width: 768px)': function () {
        reveals.forEach(function (el) {
          window.gsap.to(el, {
            opacity: 1, y: 0,
            duration: 0.6, ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 82%', once: true }
          });
        });
      },
      // Mobil — pin/scrub yok, sadece one-shot reveal
      '(max-width: 767px)': function () {
        reveals.forEach(function (el) {
          window.gsap.to(el, {
            opacity: 1, y: 0,
            duration: 0.5, ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 88%', once: true }
          });
        });
      }
    });
  }
})();
