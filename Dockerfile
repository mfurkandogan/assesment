FROM php:8.1-fpm-alpine

RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application code
COPY . /app

RUN apk update && apk add libpq-dev && docker-php-ext-install pdo_mysql

RUN adduser --disabled-password appuser
RUN chown -R appuser:appuser /app
USER appuser

# Install dependencies
RUN composer install

# Expose the port 80
EXPOSE 8080

# Set the default command to execute
# when creating a new container
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
