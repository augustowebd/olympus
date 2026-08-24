.PHONY: up down restart build logs \
	install migrate migrate-fresh test \
	sh-hidra sh-argos \
	migrate-hidra migrate-argos test-hidra test-argos

up: ## Sobe todos os containers
	docker compose up -d

down: ## Derruba todos os containers
	docker compose down

restart: down up ## Reinicia todos os containers

build: ## Rebuilda as imagens
	docker compose build

logs: ## Segue o log de todos os containers
	docker compose logs -f

sh-hidra: ## Abre um shell dentro do container da hidra
	docker compose exec hidra bash

sh-argos: ## Abre um shell dentro do container do argos
	docker compose exec argos bash

install: ## composer install + key:generate + migrate em hidra e argos
	docker compose exec hidra composer install
	docker compose exec argos composer install
	docker compose exec hidra php artisan key:generate
	docker compose exec argos php artisan key:generate
	$(MAKE) migrate

migrate: migrate-hidra migrate-argos ## Roda as migrations de hidra e argos

migrate-hidra:
	docker compose exec hidra php artisan migrate

migrate-argos:
	docker compose exec argos php artisan migrate

migrate-fresh: ## Recria o banco do zero em hidra e argos (destrutivo)
	docker compose exec hidra php artisan migrate:fresh
	docker compose exec argos php artisan migrate:fresh

test: test-hidra test-argos ## Roda os testes de hidra e argos

test-hidra:
	docker compose exec hidra php artisan test

test-argos:
	docker compose exec argos php artisan test
