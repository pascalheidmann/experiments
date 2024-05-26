FROM cgr.dev/chainguard/php:latest-dev AS builder
COPY . /app
RUN cd /app && \
    composer install --no-progress --no-dev --prefer-dist

FROM cgr.dev/chainguard/php:latest
COPY --from=builder /app /app


WORKDIR /app
EXPOSE 8000

ENTRYPOINT [ "php", "-S", "0.0.0.0:8000", "public/index.php" ]