build:
	docker build --no-cache -t my-php-app .

run:
	docker run --name collectbox -d -p 8080:80 my-php-app

stop:
	docker stop collectbox
	docker rm collectbox

ps:
	docker ps

# Here starts the fun
tests:
	docker exec -it collectbox /bin/bash -c "php ./vendor/bin/phpunit --coverage-text"
	docker exec -it collectbox /bin/bash -c "php ./vendor/bin/behat -c tests/Acceptance/behat.yml"

brt:
	docker stop collectbox
	docker rm collectbox
	docker build -t my-php-app .
	docker run --name collectbox -d -p 8080:80 my-php-app
	docker exec -it collectbox /bin/bash -c "php ./vendor/bin/phpunit --coverage-text"
	docker exec -it collectbox /bin/bash -c "php ./vendor/bin/behat -c tests/Acceptance/behat.yml"