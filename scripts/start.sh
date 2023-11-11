#!/usr/bin/env bash
set -e

echo  "Docker Compose is Starting 🐳"

if [ -f stop.sh ]; then
    echo "Stopping containers 🐳"
    ./stop.sh
fi

docker-compose up
