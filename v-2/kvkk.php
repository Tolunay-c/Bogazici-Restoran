<?php
require_once __DIR__ . '/config.php';

$aktif          = 'kvkk';
$sayfa_basligi  = 'KVKK Aydınlatma Metni — ' . SITE_ADI;
$sayfa_aciklama = 'Kişisel verilerin işlenmesine ilişkin aydınlatma metni.';

require __DIR__ . '/includes/header.php';
?>

<section class="belge">
  <div class="konteyner konteyner--dar">

    <header class="bolum-basligi">
      <p class="ustluk">Yasal</p>
      <h1 class="bolum-basligi__baslik">KVKK Aydınlatma Metni</h1>
      <p class="bolum-basligi__alt">
        6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında rezervasyon
        süreçlerinde işlenen verilere ilişkin bilgilendirme.
      </p>
    </header>

    <div class="belge__icerik">

      <p><strong>Bu metin taslaktır.</strong> Nihai içerik veri sorumlusu ve yasal
      danışman onayı sonrası yayınlanacaktır.</p>

      <h2>1. Veri Sorumlusu</h2>
      <p>
        Boğaziçi Restaurant · İzmir. İletişim:
        <a href="mailto:kvkk@bogazicirestaurant.com.tr" class="baglanti-vurgu">kvkk@bogazicirestaurant.com.tr</a>,
        <a href="tel:+902321234567" class="baglanti-vurgu">0232 123 45 67</a>.
      </p>

      <h2>2. İşlenen Kişisel Veriler</h2>
      <p>Rezervasyon formunda tarafınızdan sağlanan ad-soyad, telefon numarası,
      tarih/saat/kişi sayısı seçimleri ve varsa özel not.</p>

      <h2>3. İşleme Amaçları</h2>
      <p>Rezervasyon oluşturma ve onaylama, olası değişiklik/iptallere ilişkin
      bilgilendirme, hizmet kalitesinin ölçülmesi.</p>

      <h2>4. Aktarım</h2>
      <p>Kişisel verileriniz üçüncü kişilerle paylaşılmaz; yalnızca kanuni yükümlülük
      hâlinde yetkili kurumlarla paylaşılabilir.</p>

      <h2>5. Saklama Süresi</h2>
      <p>Veriler, rezervasyon tarihinden itibaren yasal saklama süresi kadar
      muhafaza edilir; süre sonunda silinir/anonimleştirilir.</p>

      <h2>6. Haklarınız</h2>
      <p>Kanun'un 11. maddesi uyarınca veri sorumlusuna başvurma, verilerinizin
      düzeltilmesini/silinmesini talep etme hakkınız bulunmaktadır.</p>

      <p class="belge__not">
        Son güncelleme: —.—.— · Bu içerik geçicidir; nihai metin müşteri onayı
        sonrasında eklenecektir.
      </p>
    </div>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
