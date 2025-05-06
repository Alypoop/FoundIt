#!/bin/sh

# Generate APP_KEY if not set
[ -z "$APP_KEY" ] && php artisan key:generate --force

# Wait for database to be ready
while ! php artisan db:monitor > /dev/null 2>&1; do
  echo "Waiting for database connection..."
  sleep 1
done

# Run migrations and optimize
php artisan migrate --force
php artisan optimize

# Start PHP server on port 8080
echo "Starting server on 0.0.0.0:8080"
exec php artisan serve --host=0.0.0.0 --port=8080
