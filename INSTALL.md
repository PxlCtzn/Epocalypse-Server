# Installing Epocalypse-Server for Dev 

Run the following command into a terminal

```
$ cd Path/To/The/Directory/You/Want
$ git clone https://github.com/PxlCtzn/Epocalypse-Server
$ cd Epocalypse-Server
$ composer install
$ cp .env.dist .env
$ vim .env
```
Now you can set the following parameters :
* __APP_ENV__ with one of the following value : _dev_
* __DATABASE_URL__ with something like __mysql://db_user:db_password@127.0.0.1:3306/db_name__ or __sqlite:///%kernel.project_dir%/var/data.db__

and save your change.

Now you can create the database :

```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load

```
 

Don't forget to update the JS routing file:

```
$ php  bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
```

And then start the dev server :

```
$ php bin/console server:run

```
Open the given link into your favorite browser!

 __VOILA !__ 

## Requirements

Epocalypse-Server is a symfony 4 application, therefor this project requires :
* PHP 7.1 or higher; 
* Composer.