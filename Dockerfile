FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip gd bcmath

# Node.jsをインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache設定
RUN a2enmod rewrite
COPY ./default.conf /etc/apache2/sites-available/000-default.conf

# Laravelアプリケーションをコピー
COPY ./book-management /var/www/html

# .envファイルを作成
WORKDIR /var/www/html
RUN cp .env.example .env

# .envファイルをSQLite用に修正
RUN sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
RUN sed -i 's/DB_HOST=127.0.0.1/DB_DATABASE=\/var\/www\/html\/database\/database.sqlite/' .env
RUN sed -i '/DB_PORT=/d' .env
RUN sed -i '/DB_DATABASE=/d' .env
RUN sed -i '/DB_USERNAME=/d' .env
RUN sed -i '/DB_PASSWORD=/d' .env

# Composerの依存関係をインストール
RUN composer install --no-dev --optimize-autoloader --no-interaction

# データベースファイルを作成
RUN touch /var/www/html/database/database.sqlite

# Laravelの設定
RUN php artisan key:generate
RUN php artisan migrate --force
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# vendorディレクトリの確認
RUN ls -la /var/www/html/
RUN ls -la /var/www/html/vendor/

# 権限設定
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod -R 644 /var/www/html/public/css/

WORKDIR /var/www/html