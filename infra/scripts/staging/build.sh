#!/bin/bash

docker-compose -f staging.compose.yaml up -d gateway wallets notifications suggestion
