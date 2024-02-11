-include .env
-include .env.local

.PHONY: setup
setup: build up

build: 
	docker compose build 

cli: 
	docker compose run --rm --entrypoint sh php-fpm 

up:
	docker compose up -d

down:
	docker compose down