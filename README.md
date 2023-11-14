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