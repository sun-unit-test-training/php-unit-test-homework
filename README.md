# PHP unit test training

## Setup
```sh
cp .env.example .env
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php chmod -R 777 storage bootstrap/cache
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
docker-compose exec php php artisan module:seed Exercise03
```

## Guide
To prevent conflict, each exercise is organized in its own folder with the help of package [Laravel-Modules](https://github.com/nWidart/laravel-modules), for example `Modules/Exercise01`.

Start implementing and writing unit tests for each exercise.

## Run phpunit
```sh
cp .env.testing.example .env.testing
```

Run all:
```sh
./phpunit.sh
```

Run all with coverage text:
```sh
./phpunit.sh --coverage-text
```

Run all with coverage html:
```sh
./phpunit.sh --coverage-html=coverage
```

Run only one module (see testsuites in `phpunit.xml`)
```sh
./phpunit.sh --coverage-html=coverage --testsuite=Exercise01
```

**NOTE**: You can edit file `./phpunit.sh` to use other phpunit code coverage driver. `pcov` or `phpdbg` can generate code coverage much faster than `xdebug`. Please try!

## Run infection
Run all:
```sh
./infection.sh
```

Run only one module:
```sh
./infection.sh --filter=Exercise01
```

Run only one file:
```sh
./infection.sh --filter=Modules/Exercise01/Http/Controllers/OrderController.php
```
