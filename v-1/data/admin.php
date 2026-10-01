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
    'parola_hash'  => '$2y$12$38.dT.7Sdk5xzGAt4LFsOuceCOHj/SwwJQr9VCSZyE.gNPAnzalHG',
    // Oturum çerezi imza anahtarı (sunucuya özel, paylaşmayın)
    'gizli'        => 'f8dacc6a7a155cb6da1ed766dc2c22001d412e9aa69324f3fde1f8a04f32f8b4',
    // Oturum çerezi ömrü (saniye) — 4 saat
    'oturum_omru'  => 4 * 60 * 60,
];
