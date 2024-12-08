# Use an official PHP image
FROM php:8.2-apache

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Try resolving permission error with custom Apache config
COPY ./httpd.conf /etc/apache2/sites-available/httpd.conf

# Enable the site configuration
RUN a2ensite httpd.conf
RUN apache2ctl -S


# Set the working directory
WORKDIR /var/www/html


COPY ./prototype-2 /var/www/html/


# Check the contents of /var/www/html (this will run before starting the server)
RUN ls -l /var/www/html
RUN ls -l /var/www/html/public
RUN cat /etc/apache2/sites-available/httpd.conf

# Set Composer environment variable
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction


# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/public \
    && chmod -R 755 /var/www/html/public \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Reload Apache to apply changes
RUN apache2ctl graceful


# Expose port 80
EXPOSE 80

# Start the server
CMD ["apache2-foreground"]
