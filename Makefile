install:
	docker-compose run --rm app composer install

up:
	docker-compose up -d

migrate:
	docker-compose run --rm app php bin/console doctrine:migrations:migrate --no-interaction

down:
	docker-compose down

enter:
	docker-compose exec app bash
