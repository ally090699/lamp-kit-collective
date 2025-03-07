# Use an official PHP + Apache image
FROM php:8.1-apache

# Install necessary PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files to Apache web root
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
