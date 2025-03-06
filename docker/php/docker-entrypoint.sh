#!/bin/bash

# Create Laravel storage directory structure if it doesn't exist
mkdir -p /var/www/storage/app/public
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# Set permissions
chmod -R 777 /var/www/storage
chmod -R 777 /var/www/bootstrap/cache

# Create laravel.log if it doesn't exist and set permissions
touch /var/www/storage/logs/laravel.log
chmod 666 /var/www/storage/logs/laravel.log

# Start PHP-FPM
php-fpm
