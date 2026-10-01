#!/usr/bin/env bash
# v-1'i hosting firmasına gönderilecek zip olarak paketler.
# Çıktı: dist/bogazici-restaurant-YYYYAAGG.zip
#   bogazici-restaurant/KURULUM.txt
#   bogazici-restaurant/public_html/...   (web köküne yüklenecek dosyalar)
set -euo pipefail

KOK="$(cd "$(dirname "$0")/.." && pwd)"
TARIH="$(date +%Y%m%d)"
AD="bogazici-restaurant"
GECICI="$(mktemp -d)"
HEDEF="$GECICI/$AD"
ZIP="$KOK/dist/$AD-$TARIH.zip"

mkdir -p "$HEDEF/public_html" "$KOK/dist"

rsync -a "$KOK/v-1/" "$HEDEF/public_html/" \
  --exclude '.DS_Store' \
  --exclude '.gitignore' \
  --exclude 'router.php' \
  --exclude '/*.md' \
  --exclude '/*.png' \
  --exclude 'assets/img/musteri-gorseller/' \
  --exclude 'data/mesajlar.json' \
  --exclude 'data/mail.log*' \
  --exclude 'data/*.bak-*' \
  --exclude 'data/veri.json.yedek'

cp "$KOK/tools/KURULUM-HOSTING.txt" "$HEDEF/KURULUM.txt"

rm -f "$ZIP"
(cd "$GECICI" && zip -rqX "$ZIP" "$AD")
rm -rf "$GECICI"

echo "Paket: $ZIP"
echo "Boyut: $(du -h "$ZIP" | cut -f1)"
echo "Dosya: $(unzip -Z1 "$ZIP" | grep -v '/$' | wc -l | tr -d ' ')"
