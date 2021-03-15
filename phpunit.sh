#!/bin/bash

# Using pcov
docker-compose exec -T php php -dextension=pcov.so -dpcov.enabled=1 -dpcov.directory=. -dpcov.exclude="~(config|database|node_modules|public|resources|routes|storage|tests|vendor|Config|Database|Resources|Routes|Tests|Providers)~" ./vendor/bin/phpunit $@

# Using phpdbg
# docker-compose exec -T php phpdbg -qrr ./vendor/bin/phpunit $@
# docker-compose exec -T php phpdbg -qrr artisan test --without-tty --parallel --recreate-databases $@

# Using xdebug
#docker-compose exec -T php php -dzend_extension=xdebug.so ./vendor/bin/phpunit $@
