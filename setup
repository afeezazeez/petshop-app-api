#!/bin/bash
set -e

GREEN=$(tput setaf 2)
PINK=$(tput setaf 5)

if [[ "$1" == "start" ]]; then

    echo "${PINK}Starting Docker containers ..."
    if ! docker-compose up -d; then
        echo "${PINK}Error: Failed to start Docker containers. Make sure Docker is installed and running."
        exit 1
    fi

    echo "${PINK}Building docker images ..."
        if ! docker-compose build; then
            echo "${PINK}Error: Failed to build Docker images."
            exit 1
        fi

    echo "${PINK}Generating openssl keys ..."
        mkdir -p storage/app/public/keys && \
            openssl genpkey -algorithm RSA -out storage/app/public/keys/private-key.pem && \
            openssl rsa -pubout -in storage/app/public/keys/private-key.pem -out storage/app/public/keys/public-key.pem


    echo "${PINK}Installing composer packages ..."
    if ! cp .env.example .env; then
        echo "${PINK}Error: Failed to copy .env.example to .env."
        exit 1
    fi

    if ! composer install --quiet; then
        echo "${PINK}Error: Composer installation failed."
        exit 1
    fi

    echo "${PINK}Generating app key ..."
    if ! docker-compose exec app php artisan key:generate; then
        echo "${PINK}Error: Failed to generate app key."
        exit 1
    fi



    echo "${PINK}Clearing existing database data ..."
    if ! docker-compose exec app php artisan migrate:reset; then
        echo "${PINK}Error: Failed to reset database migrations."
        exit 1
    fi

    echo "${PINK}Running migrations ..."
    if ! docker-compose exec app php artisan migrate --seed; then
        echo "${PINK}Error: Database migrations failed."
        exit 1
    fi


    echo "${PINK}Generating swagger docs ..."
            if ! docker compose exec app php artisan l5-swagger:generate; then
                echo "${PINK}Error: Failed to generate JWT secret."
                exit 1
            fi
    echo "${GREEN}Setup completed successfully!"


elif [[ "$1" == "stop" ]]; then
    echo "${PINK}Stopping Docker containers ..."
    if ! docker-compose down; then
        echo "${PINK}Error: Failed to stop Docker containers."
        exit 1
    fi
    echo "${GREEN}Docker containers stopped successfully!"
else
    echo "${PINK}Usage: $0 [start|stop]"
    exit 1
fi
