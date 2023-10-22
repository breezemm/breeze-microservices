#!/bin/sh

composer install
composer setup

exec php-fpm