#!/bin/bash
set -e

GREEN=$(tput setaf 2)

echo "${GREEN}Running larastan"

docker-compose exec app ./vendor/bin/phpstan analyse
