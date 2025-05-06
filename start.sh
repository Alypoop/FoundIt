#!/bin/sh

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force
fi

# Wait for database to be ready (crucial for Railway)
while ! php artisan db:monitor > /dev/null 2>&1; do
  echo "Waiting for database connection..."
  sleep 1
done

# Run database migrations
php artisan migrate --force

# Clear and cache config
php artisan config:clear && php artisan config:cache

# Set proper permissions
chmod -R 775 storage bootstrap/cache

# Start the server (PHP-FPM + Nginx recommended)
if [ "$USE_FPM" = "true" ]; then
  echo "Starting PHP-FPM..."
  php-fpm
else
  echo "Starting Laravel development server..."
  php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
fi
