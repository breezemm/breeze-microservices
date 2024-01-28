#!/bin/bash sh
docker compose exec gateway php artisan migrate:fresh --seed
docker compose exec gateway php artisan passport:install
docker compose exec gateway php artisan storage:link
