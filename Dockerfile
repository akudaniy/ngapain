# Use the official PHP image as the base
FROM php:8.3-fpm

# Install necessary PHP extensions and Node.js
RUN apt-get update && apt-get install -y \
  git \
  vim \
  curl \
  libonig-dev \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  libicu-dev \
  zip \
  unzip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-configure intl \
  && docker-php-ext-install gd pdo pdo_mysql mbstring exif pcntl bcmath intl zip

# Install Node.js, npm, and Bun
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs unzip \
    && npm install -g npm@latest \
    && curl -fsSL https://bun.sh/install | bash \
    && ln -s $HOME/.bun/bin/bun /usr/local/bin/bun \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy existing application files
COPY . /var/www/html

# Install Laravel dependencies
RUN composer install --no-scripts --no-autoloader

# Run additional commands if needed
RUN composer dump-autoload

# Source the aliases script
RUN echo "alias t='php artisan migrate:fresh && php artisan test'" >> /etc/bash.bashrc

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
