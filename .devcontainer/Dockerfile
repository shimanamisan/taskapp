FROM php:8.1.9-apache-bullseye

# パッケージの更新及び必要ソフトのインストール
RUN apt-get update \
  && apt-get install -yqq \
  zlib1g-dev \
  libpq-dev \
  mariadb-client \
  unzip \
  libzip-dev \
  zip \
  && docker-php-ext-install \
  pdo_mysql \
  mysqli \
  # rewriteモジュールを有効化
  && a2enmod rewrite \
  && docker-php-ext-enable mysqli \
  # xdebug install
  && pecl install xdebug \
  && docker-php-ext-enable xdebug

# Composer Install
# 公式の Composer イメージを利用
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# rootユーザー実行した際に警告が出ないようにする
ENV COMPOSER_ALLOW_SUPERUSER 1
# Composerのホームディレクトリを変更
ENV COMPOSER_HOME /composer
# コマンドが実行できるようにパスを通す
ENV PATH $PATH:/composer/vendor/bin

# Node.js Install
RUN apt-get install -y nodejs \
  npm \
  && npm install n -g \
  && n latest

# Yarn Install 
RUN npm install -g yarn

# ワークディレクトリを作成
WORKDIR /workspace

RUN composer global require "laravel/installer"

# prettier と php を prettier で整形するためのプラグインをインストール
RUN yarn add -g prettier @prettier/plugin-php
