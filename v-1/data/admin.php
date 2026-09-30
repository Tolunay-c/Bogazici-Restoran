<?php
declare(strict_types=1);

/* --------------------------------------------------------------
   Admin paneli hesap ayarları
   - Varsayılan kullanıcı: admin
   - Parola: proje sahibinde (repoda tutulmaz)
   - Parola hash'ini yenilemek için:
       php -r "echo password_hash('YENI_PAROLA', PASSWORD_BCRYPT);"
     Çıkan hash'i aşağıdaki 'parola_hash' değerine yapıştırın.
   -------------------------------------------------------------- */
return [
    'kullanici'    => 'admin',
    'parola_hash'  => '$2y$12$GpXWoLybRu0m6QzVOytLQeTSRhTjBxIm3qu.sJ1jiB2.vAd4Htyvu',
    // Oturum çerezi ömrü (saniye) — 4 saat
    'oturum_omru'  => 4 * 60 * 60,
];
