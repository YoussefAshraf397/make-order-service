#!/bin/sh

cd /var/www

# php artisan migrate:fresh --seed
#php artisan cache:clear
npm install --save-dev chokidar
composer install
php artisan key:generate
/usr/bin/supervisord -c /etc/supervisord.conf
