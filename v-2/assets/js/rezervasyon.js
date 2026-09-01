/* ==============================================================
   rezervasyon.js — şube tab'ı, SVG bölge seçimi, stepper,
   liste ↔ kroki geçişi, form hazır durumu, GSAP breathing hint
   ============================================================== */
(function () {
  'use strict';

  var azHareket = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var sayfa   = document.querySelector('[data-rez]');
  if (!sayfa) return;

  var subeler   = sayfa.querySelectorAll('.rez__sube__btn');
  var paneller  = sayfa.querySelectorAll('[data-sube-panel]');
  var form      = sayfa.querySelector('.rez__form');
  var alanBolge = sayfa.querySelector('input[name="bolge"]');
  var alanSube  = sayfa.querySelector('input[name="sube"]');
  var secimAd   = sayfa.querySelector('[data-secim-ad]');
  var secimAcik = sayfa.querySelector('[data-secim-aciklama]');
  var secimSar  = sayfa.querySelector('.rez__secim');
  var duyuru    = sayfa.querySelector('[data-duyuru]');
  var gerisi    = form ? form.querySelector('[data-gerisi]')     : null;
  var submitBtn = form ? form.querySelector('[data-submit]')     : null;
  var kvkk      = form ? form.querySelector('[data-kvkk]')       : null;

  function submitKilit() {
    if (!submitBtn) return;
    var bolgeSecili = !!(alanBolge && alanBolge.value);
    var onay        = !!(kvkk && kvkk.checked);
    submitBtn.disabled = !(bolgeSecili && onay);
  }
  if (kvkk) kvkk.addEventListener('change', submitKilit);

  /* --- Şube segmented -------------------------------------- */
  subeler.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var slug = btn.dataset.sube;
      subeler.forEach(function (b) {
        var aktif = b === btn;
        b.setAttribute('aria-selected', aktif ? 'true' : 'false');
        b.tabIndex = aktif ? 0 : -1;
      });
      paneller.forEach(function (p) {
        p.hidden = (p.dataset.subePanel !== slug);
      });
      if (alanSube) alanSube.value = slug;
      bolgeyiSifirla();
    });
    // Ok tuşlarıyla gezinme
    btn.addEventListener('keydown', function (ev) {
      var yon = { ArrowLeft: -1, ArrowRight: 1 }[ev.key];
      if (!yon) return;
      ev.preventDefault();
      var liste = Array.from(subeler);
      var i = liste.indexOf(btn);
      var hedef = liste[(i + yon + liste.length) % liste.length];
      hedef.focus(); hedef.click();
    });
  });

  /* --- Bölge seçimi (SVG + liste ortak) -------------------- */
  function bolgeSec(oge, sessizce) {
    var bolge = oge.dataset.bolge;
    var ad    = oge.dataset.ad;
    var acikl = oge.dataset.aciklama || '';
    var musait = parseInt(oge.dataset.musait || '0', 10);

    if (musait <= 0) return;

    // Aynı panel içindeki tüm bölgeleri temizle
    var panel = oge.closest('[data-sube-panel]');
    if (panel) {
      panel.querySelectorAll('[data-bolge]').forEach(function (el) {
        el.setAttribute('aria-pressed', 'false');
      });
    }
    // Ayrıca liste görünümündeki eşleşen bölgeyi de işaretle
    if (panel) {
      panel.querySelectorAll('[data-bolge="' + bolge + '"]').forEach(function (el) {
        el.setAttribute('aria-pressed', 'true');
      });
    } else {
      oge.setAttribute('aria-pressed', 'true');
    }

    if (alanBolge) alanBolge.value = bolge;
    if (secimAd)   secimAd.textContent = ad;
    if (secimAcik) secimAcik.textContent = acikl + ' · ' + musait + ' masa müsait';
    if (secimSar)  secimSar.classList.remove('rez__secim--bos');
    if (gerisi)    gerisi.disabled = false;
    submitKilit();
    if (!sessizce && duyuru) duyuru.textContent = ad + ' seçildi. ' + musait + ' masa müsait.';
  }

  function bolgeyiSifirla() {
    sayfa.querySelectorAll('[data-bolge]').forEach(function (el) {
      el.setAttribute('aria-pressed', 'false');
    });
    if (alanBolge) alanBolge.value = '';
    if (secimAd)   secimAd.textContent = '— henüz seçilmedi —';
    if (secimAcik) secimAcik.textContent = 'Devam etmek için bir bölge seçin.';
    if (secimSar)  secimSar.classList.add('rez__secim--bos');
    if (gerisi)    gerisi.disabled = true;
    submitKilit();
  }

  sayfa.querySelectorAll('[data-bolge]').forEach(function (el) {
    el.addEventListener('click', function () { bolgeSec(el); });
    el.addEventListener('keydown', function (ev) {
      if (ev.key === 'Enter' || ev.key === ' ') {
        ev.preventDefault();
        bolgeSec(el);
      }
    });
  });

  /* --- Görünüm geçişi (Kroki ↔ Liste) --------------------- */
  sayfa.querySelectorAll('[data-gorunum-btn]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var mod = btn.dataset.gorunumBtn;
      var kaptar = btn.closest('.rez__kroki');
      if (!kaptar) return;
      kaptar.querySelectorAll('[data-gorunum-btn]').forEach(function (b) {
        b.setAttribute('aria-selected', b === btn ? 'true' : 'false');
      });
      var svgSar   = kaptar.querySelector('.rez__svg-sar');
      var listeSar = kaptar.querySelector('.rez__liste');
      if (svgSar)   svgSar.hidden   = (mod !== 'kroki');
      if (listeSar) listeSar.hidden = (mod !== 'liste');
    });
  });

  /* --- Kişi sayısı stepper -------------------------------- */
  sayfa.querySelectorAll('[data-stepper]').forEach(function (kap) {
    var girdi = kap.querySelector('input[type="number"]');
    var azalt = kap.querySelector('[data-stepper-azalt]');
    var artir = kap.querySelector('[data-stepper-artir]');
    var deger = kap.querySelector('.stepper__deger');
    // Sabit — HTML attr'ından okumuyor ki dış kaynaklı değişimlerden etkilenmesin
    var MIN = 1;
    var MAK = 12;

    function guncelle(yeni) {
      if (isNaN(yeni)) yeni = MIN;
      yeni = Math.max(MIN, Math.min(MAK, yeni));
      girdi.value = String(yeni);
      if (deger) deger.textContent = yeni;
      if (azalt) azalt.toggleAttribute('disabled', yeni <= MIN);
      if (artir) artir.toggleAttribute('disabled', yeni >= MAK);
    }
    if (azalt) azalt.addEventListener('click', function () { guncelle(parseInt(girdi.value, 10) - 1); });
    if (artir) artir.addEventListener('click', function () { guncelle(parseInt(girdi.value, 10) + 1); });
    guncelle(parseInt(girdi.value, 10) || 2);
  });

  /* --- Blur validasyonu ----------------------------------- */
  sayfa.querySelectorAll('[data-dogrula]').forEach(function (girdi) {
    girdi.addEventListener('blur', function () {
      if (!girdi.value.trim()) {
        girdi.setAttribute('aria-invalid', 'true');
        var hata = document.getElementById(girdi.getAttribute('aria-describedby'));
        if (hata) hata.textContent = 'Bu alan zorunlu.';
      } else {
        girdi.removeAttribute('aria-invalid');
        var hata2 = document.getElementById(girdi.getAttribute('aria-describedby'));
        if (hata2) hata2.textContent = '';
      }
    });
  });

  /* --- Sunucudan gelen ön-seçim (POST hata dönüşü) -------- */
  if (alanBolge && alanBolge.value) {
    var slug = alanSube ? alanSube.value : null;
    var panel = slug ? sayfa.querySelector('[data-sube-panel="' + slug + '"]') : null;
    if (panel) {
      var hedef = panel.querySelector('[data-bolge="' + alanBolge.value + '"]');
      if (hedef) bolgeSec(hedef, true);
    }
  }
  // Her ihtimale karşı ilk kilit hesabı (POST dönüşünde KVKK checked olabilir)
  submitKilit();

  /* --- GSAP breathing hint (ilk 3 sn) --------------------- */
  if (window.gsap && !azHareket) {
    var ipuclari = sayfa.querySelectorAll('[data-sube-panel]:not([hidden]) .rez__bolge:not([data-musait="0"])');
    if (ipuclari.length) {
      var tl = window.gsap.timeline({ repeat: 2, yoyo: true, defaults: { duration: 0.9, ease: 'sine.inOut' } });
      tl.to(ipuclari, { opacity: 0.85, stagger: 0.12 })
        .to(ipuclari, { opacity: 1 });
      setTimeout(function () { tl.kill(); ipuclari.forEach(function (n){ n.style.opacity = ''; }); }, 3200);
    }
  }
})();
