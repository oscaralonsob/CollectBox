# Use the official PHP image as the base image
FROM php:8.1-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install nginx
RUN apt-get update && apt-get install -y \
  nginx \
  supervisor \
  zip

# Copy the application files to the container
COPY ./CollectBox /var/www/html/

# Install Composer (Dependency Manager for PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy Nginx configuration file
COPY ./conf/default.conf /etc/nginx/sites-available/default
COPY ./conf/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Expose port 80 for Nginx
EXPOSE 80

CMD ["/usr/bin/supervisord"]