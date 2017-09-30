FROM php:5.6.31-apache
RUN mkdir /code

RUN a2enmod rewrite
ADD ./etc/site.conf /etc/apache2/sites-available/000-default.conf
RUN service apache2 restart

WORKDIR /code

EXPOSE 80