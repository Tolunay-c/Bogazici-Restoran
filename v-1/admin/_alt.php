</main>
<footer class="admin-alt">
  Boğaziçi yönetim paneli · Değişiklikler <code>data/veri.json</code> dosyasına kaydedilir.
</footer>

<script>
/* Görsel seçici — dropdown değişince önizleme güncellenir */
document.querySelectorAll('[data-secici]').forEach(function (secici) {
  var sec = secici.querySelector('[data-secici-secim]');
  var img = secici.querySelector('img');
  var bos = secici.querySelector('.admin-gorsel-secici__bos');
  if (!sec || !img) return;
  sec.addEventListener('change', function () {
    if (sec.value) {
      img.src = '/assets/img/' + sec.value;
      img.hidden = false;
      if (bos) bos.hidden = true;
    } else {
      img.removeAttribute('src');
      img.hidden = true;
      if (bos) bos.hidden = false;
    }
  });
});
</script>
</body>
</html>
