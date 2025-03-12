FROM php:8.1-apache

# Install necessary PHP extensions (mysqli, pdo, pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the application files into the container
COPY . /var/www/html/

# Change ownership of the files to www-data (Apache's user)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set the ServerName to avoid warnings
RUN echo "ServerName lamp-kit-collective.onrender.com" >> /etc/apache2/apache2.conf

# Enable Apache mod_rewrite to handle clean URLs (e.g., for .htaccess)
RUN a2enmod rewrite

# Ensure proper DirectoryIndex handling (index.php first)
RUN echo "DirectoryIndex index.php index.html" > /etc/apache2/conf-available/custom.conf && \
    a2enconf custom

# Update Apache config to set the DocumentRoot to the public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/ports.conf

# Expose port 80 for the Apache server
EXPOSE 80

# Start Apache in the foreground (this keeps the container running)
CMD ["apache2-foreground"]
