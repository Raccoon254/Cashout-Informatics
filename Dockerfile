# Use the official image as a parent image.
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Get Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy local code to the container image.
WORKDIR /app
COPY . ./

# Install app dependencies.
COPY composer.json ./
COPY composer.lock ./
RUN composer install --no-scripts

# Install JavaScript dependencies and compile assets
RUN npm install && npm run build

# Run the web service on container startup.
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
