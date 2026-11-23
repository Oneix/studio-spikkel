#!/bin/sh
set -eu

install -d -m 0750 -o www-data -g www-data storage/uploads

salt_file=storage/security-salt
if [ ! -s "$salt_file" ]; then
    (umask 077; php -r 'echo bin2hex(random_bytes(32)), PHP_EOL;' > "$salt_file.tmp")
    mv "$salt_file.tmp" "$salt_file"
fi
chown root:www-data "$salt_file"
chmod 0640 "$salt_file"

runuser -u www-data -- php bin/cake.php migrations migrate --no-lock
runuser -u www-data -- php bin/cake.php seeds run ShopDemo
runuser -u www-data -- php bin/cake.php seeds run GiftCardsCatalog

exec apache2-foreground
