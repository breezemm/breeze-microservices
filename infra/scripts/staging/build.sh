#!/bin/bash

cd /home/ubuntu/breeze

docker-compose -f staging.compose.yaml up -d gateway wallets notifications
