# Create Databases
CREATE DATABASE IF NOT EXISTS `laravel`;
CREATE DATABASE IF NOT EXISTS `laravel_test`;

# Create user and grant rights
FLUSH PRIVILEGES;
CREATE USER 'laravel'@'%' IDENTIFIED BY 'secret';
GRANT ALL ON laravel.* TO 'laravel'@'%';

CREATE USER 'laravel_test'@'%' IDENTIFIED BY 'secret';
GRANT ALL ON `laravel_test%`.* TO 'laravel_test'@'%';
