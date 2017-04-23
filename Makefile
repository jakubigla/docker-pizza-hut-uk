.DEFAULT_GOAL := build

build:
	@docker-compose down && docker-compose build && docker-compose run --rm order