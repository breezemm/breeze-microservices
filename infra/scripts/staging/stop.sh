#!/bin/bash

cd /home/ubuntu/breeze

docker-compose -f staging.compose.yaml stop gateway wallets notifications suggestion
