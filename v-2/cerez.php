<?php
require_once __DIR__ . '/config.php';

$aktif          = 'cerez';
$sayfa_basligi  = 'Çerez Aydınlatma Metni — ' . SITE_ADI;
$sayfa_aciklama = 'Sitede kullanılan çerezlere ilişkin aydınlatma metni.';

require __DIR__ . '/includes/header.php';
?>

<section class="belge">
  <div class="konteyner konteyner--dar">

    <header class="bolum-basligi">
      <p class="ustluk">Yasal</p>
      <h1 class="bolum-basligi__baslik">Çerez Aydınlatma Metni</h1>
      <p class="bolum-basligi__alt">
        Bu sitede kullanılan çerezler, kullanım amaçları ve tercih yönetimi hakkında bilgilendirme.
      </p>
    </header>

    <div class="belge__icerik">

      <p><strong>Bu metin taslaktır.</strong> Nihai içerik veri sorumlusu ve yasal
      danışman onayı sonrası yayınlanacaktır.</p>

      <h2>1. Çerez Nedir?</h2>
      <p>Çerezler, ziyaret ettiğiniz web sitelerinin tarayıcınıza kaydettiği küçük metin dosyalarıdır.</p>

      <h2>2. Kullanılan Çerezler</h2>
      <p>Sitemizde yalnızca oturum ve tercih yönetimi amaçlı zorunlu çerezler kullanılmaktadır.
      Üçüncü taraf reklam veya izleme çerezi kullanılmamaktadır.</p>

      <h2>3. Kullanım Amaçları</h2>
      <p>Rezervasyon oturumu, form doğrulama ve site tercihlerinin (dil, tema) korunması.</p>

      <h2>4. Çerez Yönetimi</h2>
      <p>Tarayıcı ayarlarınızdan çerezleri silebilir veya engelleyebilirsiniz.
      Zorunlu çerezler devre dışı bırakıldığında sitenin bazı özellikleri çalışmayabilir.</p>

      <p class="belge__not">
        Son güncelleme: —.—.— · Bu içerik geçicidir; nihai metin müşteri onayı
        sonrasında eklenecektir.
      </p>
    </div>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
