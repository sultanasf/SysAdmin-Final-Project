FROM php:7.4-fpm

RUN apt-get update && apt-get install -y nginx

COPY . /var/www/html/

COPY nginx.conf /etc/nginx/sites-available/default

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --working-dir=/var/www/html/

EXPOSE 80

CMD service php7.4-fpm start && nginx -g 'daemon off;'
