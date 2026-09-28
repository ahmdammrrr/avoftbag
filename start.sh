#!/bin/bash
# Run Laravel migrations and seed the database
php artisan migrate --force --seed

# Fix permissions that might have been changed by running artisan as root
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start Apache in foreground
apache2-foreground
