# mini-site-e-commerce-api
The purpose of this project is to provide a standard REST JSON-API that would allow a mobile application or a full frontend website to display a mini e-commerce site.

> This project is only for CODNECT Company technical test purpose.

> This project is a Symfony 4 based app and uses [ADR](http://pmjones.io/adr/) as design pattern.

> This project uses [Swagger](https://swagger.io/) for the API documentation.

# Installation 
* clone the project : `git clone https://github.com/gdalyy/mini-site-e-commerce-api.git`

* inside the project folder run : `composer install`

* setup your database by changing this line in `.env` file `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

* connect the db by running the following command at the root of the project : `php bin/console doctrine:database:create`

* run this command in order to update the database schema : `php bin/console doctrine:migrations:migrate`

* now since the database is ready , we can add some data fixtures : `php bin/console doctrine:fixtures:load`

* just start the build-in symfony server to begin exploring the api : `php bin/console server:start` then go to http://localhost:8000 to use the API Sandbox

====> Enjoy :) 

# Testing 
* setup your test database by changing this line in `.env.test` file (if the file doesn't exist, copy & paste `.env` & rename :p) `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

* connect the db by running the following command at the root of the project : `php bin/console doctrine:database:create --env=test`

* run this command in order to update the database schema : `php bin/console doctrine:migrations:migrate --env=test`

* to start the functional tests type the following at the root of the project folder : `php bin/phpunit`

* if an error occurs in the step above please add this `<server name="KERNEL_CLASS" value="App\Kernel" />` after `<env name="SYMFONY_DEPRECATIONS_HELPER" value="weak" />` in the `phpunit.xml.dist` file at the root of the project folder

====> If you sees this `OK (8 tests, 29 assertions)` then everything works fine :p 

