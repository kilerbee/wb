install:
	docker-compose run --rm app composer install

migrate:
	docker-compose run --rm app php bin/console doctrine:migrations:migrate --no-iteraction

up:
	docker-compose up -d

down:
	docker-compose down
