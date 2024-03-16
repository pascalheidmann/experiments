# install
dump autoloader with composer eg
```bash
docker run --rm -it -v "$(pwd):/app" "composer/composer" dumpautoload
```

# run
```bash
docker run --rm -it -v "$(pwd):/app" -w /app  "php:8.3-alpine" php index.php
```