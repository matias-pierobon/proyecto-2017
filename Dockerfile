FROM php:5.6.31-apache
RUN mkdir /code

Add ./config/timezone.ini /usr/local/etc/php/conf.d/timezone.ini
RUN docker-php-ext-install pdo pdo_mysql


RUN a2enmod rewrite
ADD ./config/site.conf /etc/apache2/sites-available/000-default.conf
#RUN service apache2 reload

WORKDIR /code

EXPOSE 80