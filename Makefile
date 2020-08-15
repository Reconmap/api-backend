
DOCKER_IMAGE=reconmap

.PHONY: prepare
prepare: build
	docker-compose run --rm -w /var/www/webapp --entrypoint composer svc install

.PHONY: build
build:
	docker-compose build

.PHONY: run
run: 
	docker-compose up -d

.PHONY: conn_svc
connect_svc:
	docker-compose exec svc bash

.PHONY: conn_db
conn_db:
	docker-compose exec db mysql -uroot -preconmuppet reconmap

.PHONY: stop
stop:
	docker-compose stop

.PHONY: clean
clean: stop
	docker-compose down -v
	rm -rf db_data
	rm -rf vendor
