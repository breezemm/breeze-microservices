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

notification:
	@docker-compose exec notification sh

wallet:
	@docker-compose exec wallet sh

admin:
	@docker-compose exec admin sh
