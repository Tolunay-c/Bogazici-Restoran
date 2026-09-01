# Rezervasyon — Sayfa Override

> MASTER.md'deki tüm kurallar geçerli. Bu dosya sadece bu sayfaya özel
> ek/farklı davranışları belirler.

## 1. Sayfa amacı

Ziyaretçi, önce **şubeyi**, sonra **bölgeyi** (kroki veya liste üzerinden) seçer;
ardından tarih/kişi/saat/kişisel bilgi girer ve rezervasyonu onaylar. Onay
mesai saatinde telefonla verilir; sayfa **acknowledgement** üretir, canlı
takvim çakışması bu ekranda çözülmez.

## 2. Veri modeli (v-2/data/icerik.php)

Her şube için `bolgeler` dizisi:

```php
['id' => 'ic-salon', 'ad' => 'İç Salon',
 'aciklama' => '...', 'kapasite' => 40, 'musait' => 12]
```

`id` sabittir (`ic-salon`, `teras`, `bahce`, `deniz-kenari`). SVG yerleşimi
`kroki_yerlesim()` içinde `id → [x, y, w, h]` haritasıyla üretilir. Gerçek
şube krokisi geldiğinde:
1. Yeni bir `kroki_yerlesim_<slug>()` fonksiyonu eklenir.
2. Her şubede kendi yerleşimi kullanılır (SUBELER dizisinde `kroki` anahtarı taşınabilir).
3. Bu dosya güncellenir.

## 3. Şube seçici (segmented, tab pattern)

- `role="tablist"`, her buton `role="tab"` + `aria-selected` + `aria-controls`.
- Roving tabindex; sadece aktif tab `tabindex="0"`, diğerleri `-1`.
- ArrowLeft / ArrowRight ile döngüsel gezinme.
- Şube değişince form üzerindeki bölge seçimi **sıfırlanır**, form
  `data-hazir="false"` moduna döner.

## 4. Kroki / Liste görünüm

- Her şube paneli iki görünüm sunar: **Kroki** (varsayılan) ve **Liste**.
- Aynı bölgeleri iki yolla erişilebilir hâle getirir; hangisi seçilirse
  form aynı state'e taşır.
- Bu, MASTER §7.1'deki "gesture-only interaction olamaz" kuralının uygulamasıdır.

## 5. SVG etkileşim (placeholder plan)

- Her `<g class="rez__bolge">` `role="button" tabindex="0"` + `aria-label`.
- `aria-label` şablonu: **"<Ad>. <Açıklama>. <n> masa müsait."**
- Enter / Space seçer. Fare ve klavye aynı `bolgeSec()` yolunu çağırır.
- Seçim tek başına renkle iletilmez: **kalın çerçeve + fill değişimi +
  aria-pressed="true"** birlikte.
- `data-musait="0"` olan bölge `cursor: not-allowed`, tıklamada `bolgeSec()`
  erken çıkar. `disabled` semantiği liste görünümündeki `<button>` üzerinden verilir.
- `--accent (#B8863B)` bölge zeminidir; üzerindeki metin `--vurgu-ustu (#0E1B2C)` — 5.37:1 (AA).

## 6. Form davranışı

- Bölge seçilmeden form gövdesi (`.rez__form__gerisi`) opak 0.55 + `pointer-events: none`;
  submit butonu formun içinde olduğu için mekanik olarak kilit dışıdır.
- `data-hazir="true"/"false"` bu kilidin görsel karşılığı; JS bölge seçilince toggle eder.
- Aria-live duyurusu (`data-duyuru`): "İç Salon seçildi. 12 masa müsait."
- Sunucu validasyonu client'la aynı sırayı takip eder: sube → bolge → tarih → kişi → saat → ad → tel → not.
- Client blur validasyonu sadece **zorunlu boş** için hata gösterir; sunucu hataları
  form re-render'ında `role="alert"` ile ilgili alanın altında görünür.

## 7. CSRF

- `csrf_token()` session tabanlı, `hash_equals` ile karşılaştırılır.
- Token süresi doldu / geçersizse form üstünde `role="alert"` uyarısı, alanlar korunur.

## 8. Motion

- MASTER §5.3'e uygun **breathing hint**: sayfa yüklendiğinde aktif paneldeki
  müsait bölgeler 3 sn boyunca sıklıkla opaklıkla nefes alır. GSAP timeline
  `setTimeout` ile `.kill()`; inline `opacity` temizlenir.
- `prefers-reduced-motion` → hint çalışmaz.
- Şube tab değişimi: CSS transition (200ms). GSAP yok.
- Kroki ↔ Liste geçişi: `hidden` attribute toggle, animasyon yok.

## 9. Erişilebilirlik notları (bu sayfaya özel)

- Klavye kullanıcısı için tab sırası: Şube tabları → Görünüm butonları →
  Bölgeler (SVG içi tabindex) → Form alanları → Submit.
- Bölge seçildiğinde odak SVG bölgede kalır; formun ilk alanına programatik
  odak taşıma **yok** (kullanıcı bir sonraki adımı kendi tercihiyle seçer;
  otomatik odak, ekran okuyucu için gürültü olur).
- `aria-live="polite"` bölgesi sadece bölge seçim duyurusu için — validasyon
  hataları için ayrıca alan altındaki `role="alert"` mesajları var.

## 10. Placeholder → gerçek plan geçişi

Müşteriden şube krokisi geldiğinde şu değişecek:

- [ ] `kroki_yerlesim()` her şube için ayrı fonksiyona ayrılır **veya**
      `SUBELER` dizisinin `bolgeler` elemanları kendi `[x, y, w, h]`
      koordinatlarını taşır.
- [ ] `viewBox` gerçek plan oranına göre değişebilir (`800×600` yerine örn. `1000×700`).
- [ ] Duvar/yürüme yolu gibi statik dekor için ayrı `<g class="rez__dekor" aria-hidden="true">`.
- [ ] Bu doküman güncellenir, MASTER değişmez.
