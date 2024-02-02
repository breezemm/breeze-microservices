#!/usr/bin/env bash

echo "Stopping all running containers 🐳"
docker-compose down --volumes --remove-orphans
docker container prune --force
docker network prune --force
