#!/bin/bash


echo -e "Confluent Platform is Started ☁️"

docker-compose up  -d

echo -e "Waiting for Kafka to be ready ⏳"
docker exec -i kafka /usr/bin/kafka-topics \
                     --create \
                     --bootstrap-server kafka:9092 \
                     --topic my-topic \
                     --partitions 3 \
                     --replication-factor 1
docker exec -i kafka /usr/bin/kafka-topics --bootstrap-server kafka:9092 --list
echo -e "Kafka is ready 🎉"
