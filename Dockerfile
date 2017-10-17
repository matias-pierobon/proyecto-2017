FROM php:5.6.31-apache
RUN mkdir /code

ADD ./config/timezone.ini /usr/local/etc/php/conf.d/timezone.ini
RUN docker-php-ext-install pdo pdo_mysql


RUN a2enmod rewrite
ADD ./config/site.conf /etc/apache2/sites-available/000-default.conf
RUN service apache2 restart

ADD . /code

WORKDIR /code

EXPOSE 80