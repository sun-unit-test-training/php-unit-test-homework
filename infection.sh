#!/bin/bash

# Using pcov
docker-compose exec php ./vendor/bin/infection --initial-tests-php-options='-dextension=pcov.so -dpcov.enabled=1 -dpcov.directory=. -dpcov.exclude="~(config|database|node_modules|public|resources|routes|storage|tests|vendor|Config|Database|Resources|Routes|Tests|Providers)~"' $@

# Using phpdbg
# docker-compose exec php phpdbg -qrr ./vendor/bin/infection -s $@

# Using xdebug
# docker-compose exec php ./vendor/bin/infection --initial-tests-php-options='-dzend_extension=xdebug.so' $@
