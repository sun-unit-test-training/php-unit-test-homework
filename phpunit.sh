#!/bin/bash

# Using pcov
# docker-compose exec -T php php -dextension=pcov.so -dpcov.enabled=1 -dpcov.directory=. -dpcov.exclude="~(config|node_modules|public|resources|routes|storage|tests|vendor|Config|Resources|Routes|Tests|Providers)~" ./vendor/bin/phpunit $@

# Using phpdbg
# docker-compose exec -T php phpdbg -qrr ./vendor/bin/phpunit $@

# Using xdebug
docker-compose exec -T php php -dzend_extension=xdebug.so ./vendor/bin/phpunit $@
