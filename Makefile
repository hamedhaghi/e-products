.PHONY: up down start-provider provider-shell  migrate-provider seed-provider kill-provider start-app app-shell test-app kill-app

up: start-provider start-app migrate-provider seed-provider

down: kill-app kill-provider

# provider
start-provider:
	@cd ./tariff-provider-service && docker compose up -d --build

provider-shell:
	@cd ./tariff-provider-service && docker compose exec php bash

migrate-provider:
	@cd ./tariff-provider-service && docker compose exec php bash -c "bin/console doctrine:migrations:migrate --no-interaction"

seed-provider:
	@cd ./tariff-provider-service && docker compose exec php bash -c "bin/console doctrine:fixtures:load --no-interaction"

kill-provider:
	@cd ./tariff-provider-service && docker compose down -v

### provider

# app
start-app:
	@cd ./electricity-service && docker compose up -d --build

app-shell:
	@cd ./electricity-service && docker compose exec app bash

test-app:
	@cd ./electricity-service && docker exec app vendor/bin/paratest

kill-app:
	@cd ./electricity-service && docker compose down -v

### app
