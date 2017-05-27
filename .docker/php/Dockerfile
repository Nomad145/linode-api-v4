FROM deployment.manpow.com:5000/heartland/php:7.1.0

MAINTAINER Michael Phillips <michael.phillips@manpow.com>

COPY conf/php.ini /usr/local/etc/php/conf.d/
COPY conf/pool.conf /usr/local/etc/php-fpm.d/www.conf
COPY conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-pecl-xdebug.ini
COPY conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN apt-install \
    git \
    libssh2-1-dev

RUN curl -o /tmp/node.tar.xz https://nodejs.org/dist/v6.9.4/node-v6.9.4-linux-x64.tar.xz
RUN cd /usr/local && tar --strip-components 1 -xJf /tmp/node.tar.xz

RUN ln -s /usr/bin/nodejs /usr/bin/node
RUN echo '{ "allow_root": true }' > /root/.bowerrc

RUN mkdir -p /usr/src/php/ext
RUN curl -o /tmp/ssh.tar.gz https://pecl.php.net/get/ssh2-1.0.tgz
RUN tar xf /tmp/ssh.tar.gz -C /usr/src/php/ext/
RUN rm /tmp/ssh.tar.gz

RUN docker-php-pecl-install xdebug ssh2-1.0

RUN curl -sS https://getcomposer.org/installer | php -- \
      --install-dir=/usr/local/bin \
      --filename=composer && \
      echo "phar.readonly = off" > /usr/local/etc/php/conf.d/phar.ini

RUN npm install -g bower
