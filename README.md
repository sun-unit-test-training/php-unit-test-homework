# PHP unit test training

## Setup
```sh
cp .env.example .env
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php chmod -R 777 storage bootstrap/cache
docker-compose exec php php artisan key:generate
```

## Guide
To prevent conflict, each exercise is organized in its own folder with the help of package [Laravel-Modules](https://github.com/nWidart/laravel-modules), for example `Modules/Exercise01`.

Start implementing and writing unit tests for each exercise.

## Run phpunit

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
