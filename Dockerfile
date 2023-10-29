# Sử dụng hình ảnh PHP chứa Apache với PHP 8.0
FROM php:8.2-apache

# Cài đặt các phần mềm và môi trường cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Đặt thư mục làm việc là /var/www/html
WORKDIR /var/www/html

# Sao chép các tệp và thư mục của ứng dụng Laravel vào image
COPY . .

# Cài đặt Composer để quản lý các gói PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt các gói PHP của ứng dụng bằng Composer
RUN composer install

# Đặt quyền truy cập cho các tệp và thư mục trong thư mục của ứng dụng
RUN chown -R www-data:www-data storage bootstrap/cache

# Cấu hình Apache để điều hướng đến index.php của Laravel
RUN a2enmod rewrite
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Khởi động Apache
CMD ["apache2-foreground"]

RUN php artisan key:generate
RUN php artisan storage:link
