## DB 接続

```
docker compose exec app mysql -h db -u book_log -D book_log -p
pass
```

## PHP から DB に接続

```
docker compose exec app php databases/initialize_reviews_table.php
```

## docker 内に入る

```
docker compose exec app /bin/bash
```

## docker 内での SCSS のコンパイル

```
vendor/scssphp/scssphp/bin/pscss < companies/stylesheets/scss/app.scss > companies/stylesheets/css/app.css
```
