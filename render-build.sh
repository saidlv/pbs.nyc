#!/usr/bin/env bash
# exit on error
set -o errexit

# Install dependencies
composer install
npm install
npm run build

# Migrate database
php artisan migrate --force