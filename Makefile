CURRENT_DIRECTORY := $(shell pwd)

.PHONY: up stop restart build tail gateway

up:
	@docker-compose up -d

stop:
	@docker-compose stop

restart: stop up

build:
	@docker-compose up -d --build

tail:
	@docker-compose logs -f

gateway:
	@docker-compose exec gateway sh

notifications:
	@docker-compose exec notifications sh

wallets:
	@docker-compose exec wallets sh

