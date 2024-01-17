# Use the official PHP image as the base image
FROM php:8.1-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install nginx
RUN apt-get update && apt-get install -y \
  nginx \
  supervisor \
  zip \
  libpq-dev

# Install xdebug correctly
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo xdebug.mode=coverage > /usr/local/etc/php/conf.d/xdebug.ini 

# Install pdo correctly
RUN docker-php-ext-install pdo pdo_pgsql

# Copy the application files to the container
COPY ./CollectBox /var/www/html/

# Install Composer (Dependency Manager for PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --optimize-autoloader

# Copy Nginx configuration file
COPY ./conf/default.conf /etc/nginx/sites-available/default
COPY ./conf/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Secret file for render
RUN cp /var/www/html/.env /tmp/.env || echo "Env file does not exists"
RUN --mount=type=secret,id=_env,dst=/etc/secrets/.env cat /etc/secrets/.env > /var/www/html/.env || cp /tmp/.env /var/www/html/.env 

# Expose port 80 for Nginx
EXPOSE 80

CMD ["/usr/bin/supervisord"]