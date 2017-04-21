# Pipit Seed App
A starter application built on the Pipit PHP framework

## Documentation
https://tamulib.github.io/Pipit/api/

## Features
* MVC driven design
* Database abstraction layer utilizing PDO and a Repository model
* Full support for MYSQL, improved support for MSSQL
* Built in Bootstrap, HTML and JSON view renderers with easy extensibility
* User session management, including admin authorization
* CAS support
* LDAP Utility
* Convention based javascript built on jQuery provides easy modal loading, AJAX updating, and user notifications
* Offers a complete, working seed app as a starting point.

## Requires

- PHP >=5.3 (PHP7 is not yet supported)
- MySQL/MariaDB (MSSQL and other SQL flavors will work, but the install script may need tweaking)
- Composer https://getcomposer.org/doc/00-intro.md

## Basic Installation
- Clone/Download this repo
- Import the DB schema to your database using the install/pipit-tables.sql file
- Copy/Move App/Config/config_sample.php to App/Config/config.php and set the PATH_ROOT and DB_* constants to match your environment
- Run Composer from the root directory of the repo: `php [path to composer]/composer.phar install`
- Visit http://localhost/Pipit-seed/site/ and login with the default user:password (admin:changethis)
- Reset the admin password by visiting http://localhost/Pipit-seed/site/user.php?action=edit

