#!/usr/bin/env bash
set -e

echo  "Docker Compose is Starting 🐳"

if [ -f stop.sh ]; then
    echo "Stopping containers 🐳"
    ./stop.sh
fi

docker-compose up

echo  "Starting Zookeeper and Kafka"
echo "Waiting for Kafka to be ready 🐳"

# Create a topic named wallet in the kafka container
docker exec -i kafka /usr/bin/kafka-topics \
                     --create \
                     --bootstrap-server kafka:9092 \
                     --topic wallet \
                     --partitions 3 \
                     --replication-factor 1

# Bootstrap server is the kafka container
docker exec -i kafka /usr/bin/kafka-topics --bootstrap-server kafka:9092 --list

echo -e "Confluent Platform is Started ☁️"
echo -e "Kafka is ready to use 🐳"
echo -e "Kafka is running on port 9092 🐳"
echo -e "Zookeeper is running on port 2181 🐳"
