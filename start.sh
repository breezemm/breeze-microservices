#!/bin/bash


echo -e "Confluent Platform is Started ☁️"

docker-compose up -d
docker exec -i kafka /usr/bin/kafka-topics --bootstrap-server kafka:9092 --list
