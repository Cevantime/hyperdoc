start:
	cd public && php -S localhost:8000
update:
	composer install
	make migrate
	make load

migration:
	vendor/bin/doctrine-migrations migrations:diff

migrate:
	vendor/bin/doctrine-migrations migrations:migrate

load:
	bin/console fixtures:load