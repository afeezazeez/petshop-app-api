#!/bin/bash
set -e

GREEN=$(tput setaf 2)

echo "${GREEN}Running php insights ..."

docker-compose exec app php artisan insights
