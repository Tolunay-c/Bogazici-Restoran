<?php
require_once __DIR__ . '/config.php';

$aktif          = 'ik';
$sayfa_basligi  = 'İnsan Kaynakları — ' . SITE_ADI;
$sayfa_aciklama = 'Boğaziçi Restaurant ekibine katılın: açık pozisyonlar ve başvuru bilgileri.';

require __DIR__ . '/includes/header.php';
?>

<section class="belge">
  <div class="konteyner konteyner--dar">

    <header class="bolum-basligi">
      <p class="ustluk">Kurumsal</p>
      <h1 class="bolum-basligi__baslik">İnsan Kaynakları</h1>
      <p class="bolum-basligi__alt">
        Boğaziçi ailesine katılmak isteyenleri aramızda görmekten mutluluk duyarız.
      </p>
    </header>

    <div class="belge__icerik">

      <h2>Neden Boğaziçi?</h2>
      <p>1993’ten bu yana İzmir’de misafirperverliği, mutfak kalitesini ve
      ekip ruhunu merkeze alarak çalışıyoruz. Üç şubemizde salon, mutfak,
      servis ve organizasyon ekiplerimize periyodik olarak yeni takım
      arkadaşları katılıyor.</p>

      <h2>Başvuru</h2>
      <p>Özgeçmişinizi ve tercih ettiğiniz şube/pozisyon bilgisini şu adrese
      iletebilirsiniz:
      <a class="baglanti-vurgu" href="mailto:ik@bogazicirestaurant.com.tr">ik@bogazicirestaurant.com.tr</a>.
      Alternatif olarak
      <a class="baglanti-vurgu" href="/v-2/iletisim.php#form">iletişim formumuz</a>
      üzerinden de bize ulaşabilirsiniz.</p>

      <h2>Bilgi Güvenliği</h2>
      <p>Başvuru sürecinde paylaştığınız kişisel veriler, yalnızca ilgili
      pozisyon değerlendirmesi için işlenir; süreç sonunda saklama süresine
      uygun olarak silinir/anonimleştirilir. Detay için
      <a class="baglanti-vurgu" href="/v-2/kvkk.php">KVKK Aydınlatma Metni</a>.</p>

      <p class="belge__not">
        Son güncelleme: —.—.— · Açık pozisyon bilgileri ve başvuru adresi
        müşteri onayı sonrasında güncellenecektir.
      </p>
    </div>

  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
