<?php
require_once __DIR__ . '/config.php';

$aktif          = 'gizlilik';
$sayfa_basligi  = 'Gizlilik Politikası — ' . SITE_ADI;
$sayfa_aciklama = 'Site kullanımınıza ilişkin gizlilik uygulamalarımız.';

require __DIR__ . '/includes/header.php';
?>

<section class="belge">
  <div class="konteyner konteyner--dar">

    <header class="bolum-basligi">
      <p class="ustluk">Yasal</p>
      <h1 class="bolum-basligi__baslik">Gizlilik Politikası</h1>
      <p class="bolum-basligi__alt">
        Bu sitenin kullanımı sırasında hangi verilerin ne amaçla toplandığını,
        çerezlerin nasıl kullanıldığını açıklar.
      </p>
    </header>

    <div class="belge__icerik">

      <p><strong>Bu metin taslaktır.</strong> Nihai içerik müşteri onayı sonrası
      yayınlanacaktır.</p>

      <h2>1. Toplanan Bilgiler</h2>
      <p>Ziyaret sırasında, teknik nedenlerle IP adresi, tarayıcı ve cihaz bilgisi
      gibi anonim veriler işlenebilir. Rezervasyon formuyla iletilen kişisel
      veriler için ayrıntı için
      <a href="/kvkk.php" class="baglanti-vurgu">KVKK Aydınlatma Metni</a>.</p>

      <h2>2. Çerezler</h2>
      <p>Site oturum çerezleri ve tercihlerinize ilişkin çerezler kullanır.
      Reklam / analitik çerez kullanılmaz. Tarayıcı ayarlarınızdan çerezleri
      silebilirsiniz.</p>

      <h2>3. Üçüncü Taraf Servisleri</h2>
      <p>Yazı tipleri Google Fonts üzerinden yüklenir; harita entegrasyonu, ödeme
      veya analitik üçüncü taraflar dâhil edilirse bu bölüm güncellenecektir.</p>

      <h2>4. Veri Güvenliği</h2>
      <p>Aktarım sırasında iletişim TLS ile şifrelenir; formlarda CSRF koruması
      uygulanır. Yine de internet ortamının doğası gereği %100 güvenlik
      garanti edilemez.</p>

      <h2>5. İletişim</h2>
      <p>
        <a href="mailto:info@bogazicirestaurant.com.tr" class="baglanti-vurgu">info@bogazicirestaurant.com.tr</a>
      </p>

      <p class="belge__not">
        Son güncelleme: —.—.— · Bu içerik geçicidir; nihai metin müşteri onayı
        sonrasında eklenecektir.
      </p>
    </div>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
