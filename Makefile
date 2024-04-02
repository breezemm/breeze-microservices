CURRENT_DIRECTORY := $(shell pwd)

SERVICE ?= $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))

.PHONY: up stop restart build tail gateway a gateway-seed notifications wallets

up:
	@docker-compose up -d

stop:
	@docker-compose stop

restart: stop up

a:
	@docker-compose exec $(SERVICE)

build:
	@docker-compose up -d --build

tail:
	@docker-compose logs -f


gateway-seed:
	@docker-compose exec gateway php artisan db:seed

notifications:
	@docker-compose exec notifications sh

wallets:
	@docker-compose exec wallets sh

