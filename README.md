## phpstan

```bash
./vendor/bin/phpstan analyse --memory-limit=2G
```

## db

```bash
touch database/database.sqlite
```

Then in `.env` file comment out all DB_* entries except from:
```
DB_CONNECTION=sqlite
```

then 
```bash
php artisan migrate
```

## Debugbar
```bash
composer require barryvdh/laravel-debugbar --dev
```

## filament

### install
* Install fillament
* create user

Both are in the docs.

### creating resources
```bash
php artisan make:filament-resource Owner
```

## File uploads storage

```bash
php artisan storage:link
```

Don't forget to add port in .env for APP_URL, if images don't load

## Filament tables

* Remember to cast enums and dates in related models

Publish configuration for filament (not usually needed)

```bash
php artisan vendor:publish --tag=filament-config
```