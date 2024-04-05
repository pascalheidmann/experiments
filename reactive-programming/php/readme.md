# Composer
```bash
docker run --rm -it -v "$(pwd):/app" "composer/composer" install 
```

# Promise V1
```bash
docker run --rm -it -v "$(pwd):/app" -w '/app' "php:alpine" php ./src/examples/promise-v1.php
```