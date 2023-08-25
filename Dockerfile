FROM alpine:3.16.0

RUN echo "http://dl-cdn.alpinelinux.org/alpine/v3.13/community" >> /etc/apk/repositories \
    && echo "http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \
    && apk update \
    && apk add supervisor nginx openrc php7 php7-fpm php7-mcrypt php7-soap php7-openssl php7-gmp php7-pdo_odbc php7-json php7-dom php7-pdo php7-zip php7-mysqli php7-sqlite3 php7-apcu php7-pdo_pgsql php7-bcmath php7-gd php7-odbc php7-pdo_mysql php7-pdo_sqlite php7-gettext php7-xmlreader php7-xmlrpc php7-bz2 php7-iconv php7-pdo_dblib php7-curl php7-ctype php7-phar php7-mbstring php7-session php7-tokenizer php7-simplexml \
    && openrc \
    && touch /run/openrc/softlevel \
    && adduser -D -g 'www' www \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /www

VOLUME [ "/sys/fs/cgroup" ]

RUN chown -R www:www /var/lib/nginx \
    && chown -R www:www /www

COPY ./php/php.ini /etc/php7/php.ini
COPY ./php/www.conf /etc/php7/php-fpm.d/www.conf
COPY ./supervisord/supervisord.conf /etc/supervisord.conf

EXPOSE 80 443 9000

CMD ["supervisord", "-n"]
