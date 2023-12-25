#!/bin/bash
php-fpm

php artisan optimize:clear;
php artisan package:discover --ansi;
php artisan event:cache;
php artisan route:cache;

#should be changed in development environment
php artisan octane:start --server=swoole --host=0.0.0.0 --port=80 --workers=auto --task-workers=auto --max-requests=500
