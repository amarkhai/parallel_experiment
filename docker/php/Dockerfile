FROM php:8.0-zts

RUN apt-get -y update && apt-get -y install git

RUN git clone https://github.com/krakjoe/parallel.git \
    && cd parallel \
    && phpize \
    && ./configure --enable-parallel \
    && make \
    && make test \
    && make install

RUN docker-php-ext-enable parallel