#!/bin/bash
# Run Laravel migrations and seed the database
php artisan migrate --force --seed

# Start Apache in foreground
apache2-foreground
