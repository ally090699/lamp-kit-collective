FROM php:8.1-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the application files into the container
COPY . /var/www/html/

# Change ownership of files to Apache's user
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set the ServerName
RUN echo "ServerName lamp-kit-collective.onrender.com" >> /etc/apache2/apache2.conf

# Enable necessary Apache modules
RUN a2enmod rewrite

# Ensure proper DirectoryIndex handling
RUN echo "DirectoryIndex index.php index.html" > /etc/apache2/conf-available/custom.conf && \
    a2enconf custom

# Fix DocumentRoot references (only in VirtualHost file)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN sed -i 's|Listen 80|Listen 0.0.0.0:80|' /etc/apache2/ports.conf

# Expose port 80
EXPOSE 80

# Start Apache (alternative way to keep it running)
CMD ["apachectl", "-D", "FOREGROUND"]
