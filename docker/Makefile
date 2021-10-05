include .env-example
-include .env

up:
	cp .env ../app/.env
	docker-compose up -d --build
ifeq ("dev", "$(APP_ENV)")
	docker-compose exec php_checklist composer install
else
	docker-compose exec php_checklist composer install --no-dev
endif
	docker-compose exec php_checklist chmod -R 777 .
	docker-compose exec php_checklist bin/console doctrine:database:create --if-not-exists
	docker-compose exec php_checklist bin/console doctrine:migrations:migrate --no-interaction

up-prod:
	cp .env.prod-example .env
	cp .env.prod-example ../app/.env
	docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build
	docker-compose exec php_checklist composer install --no-dev
	docker-compose exec php_checklist bin/console doctrine:database:create --if-not-exists
	docker-compose exec php_checklist bin/console doctrine:migrations:migrate --no-interaction

down:
	docker-compose down

down-prod:
	docker-compose -f docker-compose.prod.yml down
shell:
	docker-compose run php_checklist bash

env:
	if ! test -f ".env"; then cp .env-example .env && vi .env; fi

env-prod:
	if ! test -f ".env"; then cp .env.prod-example .env; fi

tests:
	docker-compose exec php_checklist php bin/console --env=test doctrine:database:drop --force || true
	docker-compose exec php_checklist php bin/console --env=test doctrine:database:create
	docker-compose exec php_checklist php bin/console --env=test doctrine:migrations:migrate -n
	docker-compose exec php_checklist php bin/console --env=test doctrine:fixtures:load -n
	docker-compose exec php_checklist ./vendor/bin/phpunit
.PHONY: tests