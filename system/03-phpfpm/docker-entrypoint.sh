#!/bin/bash
set -e

green='\033[0;32m'
purple='\033[0;35m'
nc='\033[0m' #no color

printf "${purple}Start install composer packages${nc}\n"
composer install
printf "${green}Composer installed [OK]${nc}\n"



printf "${purple}Start clearing cache!${nc}\n"
php bin/console cache:pool:clear cache.global_clearer
printf "${green}Cache cleared [OK]${toend}\n"

exec "$@"