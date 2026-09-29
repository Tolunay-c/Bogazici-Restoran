# Boğaziçi Restaurant — Sunucu Kurulum Rehberi

Bu döküman, siteyi paylaşımlı hosting (cPanel/DirectAdmin), kendi VPS/sunucun (Ubuntu/Debian + Nginx/Apache) veya Vercel üzerinde yayına almak için gereken adımları kapsar.

---

## 1. Sistem gereksinimleri

| Bileşen | Minimum | Notlar |
|---|---|---|
| PHP | **8.1+** | 8.2/8.3 önerilir. `strict_types` kullanılıyor. |
| PHP eklentileri | `mbstring`, `fileinfo`, `json`, `session` | Neredeyse tüm hosting'lerde yüklüdür. |
| Disk | ~50 MB kod + görseller (müşteriye göre büyür) | Görsel sınırı yok. |
| RAM | 128 MB PHP memory_limit | Yeterli. |
| Veritabanı | **YOK** | Tüm veri `data/veri.json` içinde. |
| SSL sertifikası | Zorunlu | Admin paneli parola giriyor, HTTPS şart. |

---

## 2. Klasör yapısı (yayında ne durur?)

```
public_html/            ← web kökü
├── index.php
├── kurumsal.php
├── subeler.php
├── menu.php
├── hizmetler.php
├── galeri.php
├── rezervasyon.php
├── iletisim.php
├── config.php
├── router.php
├── assets/
│   ├── css/
│   ├── js/
│   ├── fonts/
│   └── img/            ← YAZILABİLİR olmalı (chmod 755, sahibi web user)
├── data/
│   ├── icerik.php
│   ├── varsayilan.php
│   ├── admin.php       ← Parola hash'i burada
│   └── veri.json       ← Admin değişiklikleri (yazılabilir, chmod 664)
├── includes/
└── admin/
    ├── index.php
    ├── giris.php
    ├── ... (diğer admin dosyaları)
    └── stil.css
```

**İki sürüm var:** `v-1/` mevcut sürüm, `v-2/` yeni tasarım. Şu an root `/` v-1'i serve ediyor (bkz. `api/index.php`). Sadece **v-1** klasörünün içeriğini yükle, `v-2` isteğe bağlı.

---

## 3. Kurulum — Paylaşımlı Hosting (cPanel / DirectAdmin)

1. **Domain'i bağla**  
   Sağlayıcının panelinden `bogazicirestaurant.com.tr` domain'ini yeni bir hosting alanına yönlendir.

2. **PHP sürümünü ayarla**  
   cPanel → *MultiPHP Manager* → domaine **PHP 8.1+** seç.

3. **Dosyaları yükle**  
   `v-1/` klasörünün içindeki tüm dosyaları FTP/SFTP veya cPanel File Manager ile `public_html/` içine kopyala. **`v-1` klasörünü içine değil**, içindekileri doğrudan `public_html/` altına.

4. **İzinleri ayarla**  
   SSH veya File Manager'dan:
   ```bash
   chmod 755 data
   chmod 755 assets/img
   chmod 664 data/admin.php
   touch data/veri.json && chmod 664 data/veri.json
   ```
   Yazılabilir olması gereken tek yer: `data/` (JSON yazımı) ve `assets/img/` (upload).

5. **Admin parolasını değiştir** (aşağıda bkz. §7)

6. **HTTPS'i aç** — cPanel → *SSL/TLS Status* → Let's Encrypt otomatik.

7. **Test et** — tarayıcıda:
   - `https://bogazicirestaurant.com.tr` → ana sayfa açılmalı
   - `https://bogazicirestaurant.com.tr/admin/` → giriş ekranı çıkmalı

---

## 3B. Kurulum — DirectAdmin (adım adım)

DirectAdmin genelde cPanel'den daha sade bir arayüz; işlemler aynı ama menü isimleri farklı.

### 3B.1 PHP sürümünü seç
- DirectAdmin sol menü → **Domain Setup** → domain adına tıkla
- **PHP Version:** açılırdan **PHP 8.1** veya üstünü seç
- **PHP Extensions** listesinde şunlar işaretli olmalı:
  - `gd` (görsel türev üretimi için **ZORUNLU**)
  - `mbstring`, `fileinfo`, `openssl`, `session`, `json` (varsayılan açık)
- **Save** ile onayla

`gd` eklentisi listede yoksa hosting desteğinden aç istemek gerek — bu olmadan görsel yükleme çalışır ama responsive türevler (`-480/-960/-1440/-2200`) üretilmez, yalnızca base dosya kopyalanır (fallback).

### 3B.2 Dosyaları yükle
- **Yol 1 — FTP/SFTP (önerilen, hızlı):** FileZilla ile bağlan (host: domain veya IP, port 21/22, kullanıcı adı DirectAdmin'in verdiği). `v-1/` klasörünün **içeriğini** (klasörün kendisini değil) sürükle → `/domains/senindomain.com/public_html/` klasörüne bırak.
- **Yol 2 — File Manager:** DirectAdmin → **File Manager** → `public_html/` → *Upload files* → `v-1/*` içeriğini yükle (klasör yükleme için önce `v-1.zip` sıkıştır, yükle, sağ tık → *Extract*).

Yükleme sonrası `public_html/` içinde şunlar olmalı:
```
public_html/
├── index.php
├── kurumsal.php, subeler.php, menu.php, hizmetler.php,
│   galeri.php, rezervasyon.php, iletisim.php, sube.php
├── config.php
├── admin/
├── assets/  (css, js, fonts, img)
├── data/    (icerik.php, varsayilan.php, admin.php)
└── includes/
```

### 3B.3 Dosya izinleri
DirectAdmin File Manager'da klasöre/dosyaya sağ tık → **Set Permissions**. Terminal'de olsaydı:
```
data/            → 755
data/veri.json   → 644 (yoksa File Manager → New File → oluştur)
data/*.php       → 644
assets/img/      → 755
assets/img/*     → 644
```

### 3B.4 `.htaccess` (yoksa oluştur)
`public_html/` altında `.htaccess` dosyası oluştur (File Manager → *New File*):

```apache
DirectoryIndex index.php

<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^ index.php [L]
</IfModule>

# data/ dizinine dışarıdan erişim yok
RewriteRule ^data/ - [F,L]

# Gzip
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css application/javascript image/svg+xml
</IfModule>

# Cache — görseller uzun, HTML kısa
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp "access plus 1 year"
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/png  "access plus 1 year"
  ExpiresByType text/css   "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"
  ExpiresDefault "access plus 1 hour"
</IfModule>
```

### 3B.5 SSL (Let's Encrypt)
- DirectAdmin sol menü → **SSL Certificates** → domain seç
- **Free & automatic certificate from Let's Encrypt** işaretle → **Save**
- Sertifika kurulduktan sonra aynı sayfada **Force SSL with HTTPS redirect** işaretini aç

### 3B.6 Admin parolasını değiştir
İlk giriş sonrası **ZORUNLU** (varsayılan `admin / bogazici2026`).

- **SSH varsa:**
  ```bash
  php -r "echo password_hash('yeni_parola_buraya', PASSWORD_BCRYPT), PHP_EOL;"
  ```
- **SSH yoksa:** [bcrypt-generator.com](https://bcrypt-generator.com/) gibi bir sitede parolanı **cost=12** ile hashle (şifreni asla üçüncü sitelerde uzun süre bırakma; hash aldıktan sonra sitede geçmişi temizle).

Çıkan `$2y$12$...` değerini File Manager'dan `public_html/data/admin.php` içine yapıştır:
```php
'parola_hash' => '$2y$12$yeniHashBuraya...',
```

### 3B.7 Yedekleme (DirectAdmin panelinden)
- Sol menü → **Create/Restore Backups** → *Create Backup* → aşağıdakileri seç:
  - E-mail data ✗
  - Databases ✗ (bu projede yok)
  - Domains Directory ✓ (kod + `data/veri.json` + görseller)
- İdeal: sağlayıcının **otomatik yedek** planını aç (günlük/haftalık)
- Kritik dosya: `public_html/data/veri.json` — admin edit'leri burada tutuluyor

### 3B.8 Test et
- `https://senindomain.com/` → anasayfa (Boğaziçi hero)
- `https://senindomain.com/admin/` → giriş formu
- Giriş yap → dashboard
- Bir bölümde metni değiştir → **Değişiklikleri kaydet** → anasayfayı yenile → yeni metin görünmeli
- **Görseller** sayfasından test görseli yükle → kaydet → frontend'de göründü mü?

---

## 4. Kurulum — VPS (Ubuntu + Nginx)

### 4.1 Bağımlılıklar

```bash
sudo apt update
sudo apt install -y nginx php8.2-fpm php8.2-mbstring php8.2-cli php8.2-common certbot python3-certbot-nginx
```

### 4.2 Dosyaları yerleştir

```bash
sudo mkdir -p /var/www/bogazici
sudo rsync -av v-1/ /var/www/bogazici/
sudo chown -R www-data:www-data /var/www/bogazici
sudo chmod -R 755 /var/www/bogazici
sudo chmod -R 775 /var/www/bogazici/data /var/www/bogazici/assets/img
```

### 4.3 Nginx yapılandırması

`/etc/nginx/sites-available/bogazici` dosyasını oluştur:

```nginx
server {
    listen 80;
    server_name bogazicirestaurant.com.tr www.bogazicirestaurant.com.tr;
    root /var/www/bogazici;
    index index.php;

    # Statik dosyalar (görseller, css, js) doğrudan servis edilir
    location ~* \.(webp|jpg|jpeg|png|gif|svg|css|js|woff2|ico)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    # data/ dizinini dış dünyaya kapat (JSON'a doğrudan erişilmesin)
    location ~* /data/.*\.(json|php)$ {
        deny all;
        return 404;
    }

    # PHP
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Diğer istekler
    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    # Upload sınırı
    client_max_body_size 12M;
}
```

Aktifleştir:
```bash
sudo ln -s /etc/nginx/sites-available/bogazici /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

### 4.4 HTTPS

```bash
sudo certbot --nginx -d bogazicirestaurant.com.tr -d www.bogazicirestaurant.com.tr
```

Otomatik yenileme cron'u zaten kurulur.

### 4.5 PHP-FPM ayarları

`/etc/php/8.2/fpm/php.ini` içinde:
```ini
upload_max_filesize = 12M
post_max_size = 16M
memory_limit = 256M
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```

Reload:
```bash
sudo systemctl reload php8.2-fpm
```

---

## 5. Kurulum — Apache (mod_php veya PHP-FPM)

### 5.1 VirtualHost

`/etc/apache2/sites-available/bogazici.conf`:

```apache
<VirtualHost *:80>
    ServerName bogazicirestaurant.com.tr
    ServerAlias www.bogazicirestaurant.com.tr
    DocumentRoot /var/www/bogazici

    <Directory /var/www/bogazici>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/bogazici-error.log
    CustomLog ${APACHE_LOG_DIR}/bogazici-access.log combined
</VirtualHost>
```

### 5.2 `.htaccess` — projeye ekle

Proje kökünde `.htaccess`:

```apache
# data/ dizinine doğrudan erişimi kapat
<FilesMatch "\.(json|php)$">
    <If "%{REQUEST_URI} =~ m#^/data/#">
        Require all denied
    </If>
</FilesMatch>

# Uzantısız temiz URL (opsiyonel)
Options -MultiViews
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^\.]+)$ $1.php [NC,L]

# Gzip
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css application/javascript image/svg+xml
</IfModule>

# Cache statik
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/webp "access plus 30 days"
    ExpiresByType image/jpeg "access plus 30 days"
    ExpiresByType text/css "access plus 7 days"
    ExpiresByType application/javascript "access plus 7 days"
</IfModule>
```

Aktifleştir:
```bash
sudo a2enmod rewrite expires deflate
sudo a2ensite bogazici
sudo systemctl reload apache2
sudo certbot --apache -d bogazicirestaurant.com.tr -d www.bogazicirestaurant.com.tr
```

---

## 6. Kurulum — Vercel (mevcut config)

Proje köküne `vercel.json` zaten ekli, `vercel-php` runtime kullanır.

1. `vercel login`
2. `vercel --prod`
3. Vercel dashboard'dan domain ekle: *Settings → Domains → bogazicirestaurant.com.tr*.

**Dikkat:** Vercel serverless — `data/veri.json` her deploy'da resetlenir (ephemeral). Vercel'i kullanacaksan içerik yönetimi için başka bir çözüm (Vercel Blob, Postgres, veya harici GitHub commit) gerekir. Klasik hosting/VPS önerilir.

---

## 7. Admin parolasını değiştir

Sunucuda SSH ile:

```bash
php -r "echo password_hash('YENI_PAROLA', PASSWORD_BCRYPT), PHP_EOL;"
```

Çıkan hash'i `data/admin.php` içindeki `parola_hash` değerine yapıştır:

```php
'parola_hash' => '$2y$12$xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
```

Kullanıcı adını da değiştirebilirsin (`'kullanici' => 'yeniad'`).

**Varsayılan:** `admin / bogazici2026` — canlıya çıkmadan önce mutlaka değiştir.

---

## 8. İçerik yedekleme

Admin panelinden yapılan tüm değişiklikler `data/veri.json` dosyasında saklanır. Her kaydetmeden önce otomatik olarak `data/veri.json.yedek` alınır (bir önceki sürüm).

**Manuel yedek (önerilen — günlük cron):**

```bash
# /etc/cron.daily/bogazici-yedek
#!/bin/bash
YEDEK=/var/backups/bogazici
mkdir -p "$YEDEK"
cp /var/www/bogazici/data/veri.json "$YEDEK/veri-$(date +%Y%m%d).json"
tar -czf "$YEDEK/img-$(date +%Y%m%d).tar.gz" /var/www/bogazici/assets/img
# 30 günden eskileri temizle
find "$YEDEK" -mtime +30 -delete
```

```bash
sudo chmod +x /etc/cron.daily/bogazici-yedek
```

**Sıfırlama:** admin panelinden bozulmuş bir kayıt kurtarmak istersen `data/veri.json`'u sil → site `varsayilan.php`'deki fabrika ayarlarına döner. Değişiklikleri geri almak için:
```bash
mv data/veri.json.yedek data/veri.json
```

---

## 9. Güvenlik kontrol listesi

- [ ] HTTPS zorunlu (HTTP → HTTPS redirect kurulu)
- [ ] Admin parolası değişti, `bogazici2026` DEĞİL
- [ ] `data/*.json` ve `data/*.php` web'den doğrudan erişilemiyor (bkz. §4/§5 nginx/apache kuralları)
- [ ] `session.cookie_secure = 1` (HTTPS zorunluluğu)
- [ ] Upload dizini (`assets/img/`) PHP çalıştırmıyor (Nginx'te otomatik, Apache'de `.htaccess` içinde `php_flag engine off` eklenebilir)
- [ ] Günlük veri yedeği çalışıyor
- [ ] `error_reporting` üretimde kapalı (php.ini → `display_errors = Off`)

---

## 10. Sorun giderme

**"Kayıt başarısız (izin kontrol edin)"**  
`data/` dizini web user'a yazılabilir değil:
```bash
sudo chown -R www-data:www-data /var/www/bogazici/data /var/www/bogazici/assets/img
sudo chmod 775 /var/www/bogazici/data /var/www/bogazici/assets/img
```

**Görsel yüklerken "dosya çok büyük"**  
Nginx `client_max_body_size`, PHP `upload_max_filesize` ve `post_max_size` değerlerini 12M+ yap.

**Admin'e giriş yaptım ama tekrar giriş ekranı açılıyor**  
Session cookie kaydedilmiyor — muhtemelen HTTPS'de `session.cookie_secure=1` ama site HTTP'den açılıyor. HTTPS'e yönlendir.

**Anasayfada eski içerik görünüyor**  
`data/veri.json` eski verileri barındırıyor. Adminden yeniden kaydet veya dosyayı sil.

**404 — `admin/` bulunamıyor**  
Nginx'te try_files zinciri hatalı olabilir; PHP-FPM sock yolunu (`php8.2-fpm.sock`) doğrula.

---

## 11. Güncelleme akışı

Yeni bir versiyon geldiğinde:

1. Mevcut `data/veri.json`'u bir yere kopyala.
2. Kod dosyalarını üzerine yaz (rsync veya git pull).
3. `data/veri.json`'u geri koy.
4. Sunucu cache'ini temizle (opsiyonel: OPcache reset).

```bash
sudo systemctl reload php8.2-fpm
```

---

## 12. İletişim / Destek

- Kod: `data/varsayilan.php` fabrika ayarları, `admin/` panel dosyaları.
- Admin panel URL: `https://SITE/admin/`
- Yardım: geliştirici ekibine ulaş.

---

**Son kontrol:** kurulumdan sonra bu URL'leri kontrol et:
- `/` — ana sayfa
- `/menu.php` — 8 kategori (Başlangıçlar, Mezeler, Ara Sıcaklar, Salatalar, Kebaplar, Balıklar, Pideler, Tatlılar)
- `/subeler.php` — 3 şube (Üçkuyular, Narlıdere, Bostanlı) haritayla
- `/rezervasyon.php` — 3 şube sekmesi + form çalışıyor
- `/admin/` — giriş ekranı → dashboard
- `/admin/gorsel.php` → yükleme çalışıyor, kütüphane kullanım rozetleri görünüyor
