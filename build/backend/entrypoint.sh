#!/usr/bin/env sh

if ! [ -f "$(pwd)/artisan" ]; then
  composer create-project laravel/laravel initial
  cp -a "$(pwd)/initial/." "$(pwd)"
  rm -r "$(pwd)/initial"
fi

composer install

php artisan migrate

php artisan db:seed

php "$(pwd)/artisan" serve --port="$PORT" --host 0.0.0.0
