-include .env
-include .env.local

.PHONY: setup
setup: build up

build: 
	docker compose -f ./compose.yaml -f ./compose.override.yaml build 

cli: 
	docker compose run --rm --entrypoint sh php

up:
	HTTP_PORT=9999  docker compose -f ./compose.yaml -f ./compose.override.yaml up  

down:
	docker compose -f ./compose.yaml -f ./compose.override.yaml down --remove-orphans  -v 

up-test:
	HTTP_PORT=9999  docker compose -f ./compose.test.yaml up 
	
down-test:
	docker compose -f ./compose.test.yaml down --remove-orphans  -v 

build-prod:
	TARGET=prod docker compose build

push-prod:
	TARGET=prod docker compose push
