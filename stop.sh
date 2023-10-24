#!/usr/bin/env bash

echo -e "Confluent Platform is Stopped ☁️"

docker-compose down --volumes --remove-orphans
