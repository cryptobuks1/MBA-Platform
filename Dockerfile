FROM php:7-apache
LABEL SlashCode hello@slashcode.io
COPY . /var/www/html
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]