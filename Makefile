.PHONY: prepare run stop kill
.DEFAULT_GOAL := run

prepare:
	composer install

run: prepare
	docker-compose -p example up -d

stop:
	docker-compose -p example stop

kill:
	docker-compose -p example kill
