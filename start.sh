#!/bin/sh

# Generate APP_KEY if not set
[ -z "$APP_KEY" ] && php artisan key:generate --force

# Wait for database
while ! php artisan db:monitor > /dev/null 2>&1; do
  echo "Waiting for database..."
  sleep 1
done

# Run migrations
php artisan migrate --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start server
php artisan serve --host=0.0.0.0 --port=8080
