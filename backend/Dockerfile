FROM php:8.1-fpm
# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . /var/www/html

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.mode = debug" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.start_with_request = yes" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.client_host = host.docker.internal" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.client_port = 9000" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.cli_color = 2" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.dump.* = *" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.dump_globals = true" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.force_display_errors = 1" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.log = /var/www/html/log/xdebug.log" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && echo "xdebug.log_level = 7" >> "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]
