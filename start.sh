#!/bin/sh

# Start PHP server on port 8080
echo "Starting server on 0.0.0.0:8080"
exec php artisan serve --host=0.0.0.0 --port=8080
