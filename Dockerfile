FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN echo "ServerName lamp-kit-collective.onrender.com" >> /etc/apache2/apache2.conf && \
    a2enmod rewrite && \
    service apache2 restart
    
EXPOSE 80

CMD ["apache2-foreground"]
