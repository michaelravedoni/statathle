# StatAthle

A statistics PHP web app for athletics organisations

[![license](https://img.shields.io/github/license/michaelravedoni/statathle.svg)]()
[![GitHub release](https://img.shields.io/github/release/michaelravedoni/statathle.svg)]()
[![Github All Releases](https://img.shields.io/github/downloads/michaelravedoni/atom/statathle.svg)]()

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You need to have :

- PHP 5.3+
- MySQL
- mod_rewrite activated, document root routed to /public (tutorial below)
- [Composer](https://getcomposer.org/download/) installed

### Installing

#### Vargrant

#### Auto-Installation

#### Manual installation

##### 1. Activate mod_rewrite and ...

Tutorials for [Ubuntu 14.04 LTS](http://www.dev-metal.com/enable-mod_rewrite-ubuntu-14-04-lts/) and 
[Ubuntu 12.04 LTS](http://www.dev-metal.com/enable-mod_rewrite-ubuntu-12-04-lts/).

##### 2. Edit the development configurations

Inside `app/config`, make configs your own. There is 3 files : `env.php`, `db.php` and `config.yml`.

###### 2.1 Environment

Inside `app/config/env.php`, set the environment mode. Choose between 'development' and 'production' :

```php
'mode' => 'development'
```

###### 2.2 Database

Inside `app/config/db.php` edit the database credentials and fill in your values. There is 2 arrays. One for 'development' mode and one for production mode.

```php
'driver' => 'mysql',
'host' => 'localhost',
'port' => '1234',
'database' => 'stats',
'username' => 'root',
'password' => 'root',
'charset' => 'utf8',
'collation' => 'utf8_unicode_ci'
```

###### 2.2 Configurations

Inside `app/config/config.yml`, you can customize the app and dependencies.

```yml
language_code               : ''
app_name                    : 'StatAthlé'
organisation_name           : 'Organisation Name'
launch_year                 : '2017'
data_licence                : 'by/4.0'

```

##### 3. Execute the SQL statements
 
Inside `_install` folder execute the 3 `sql` queries files with PHPMyAdmin or [SequelPro](https://github.com/sequelpro/sequelpro) to create the demo database.

##### 4. Get dependencies via Composer
 
Install all dependencies in the project's root folder to fetch the dependencies and to create the autoloader :

```bash
$ cd <project_name>
$ composer install
```

or 

```bash
$ php composer.phar install
```
##### 5. Customize the home page

Inside `app/view/_notes.twig`, make content yours. Your can add information about versionning, data source of data, history, credentials, cool stuff etc.

```html
<h2>Notes</h2>
<p>Le module des statistique et résultats du <i>{{config.organisation_name}}</i> est en version beta. Il reprend d'anciennes bases de résultats allant de 1962 à 2010 et pouvant contenir des erreurs et bugs (résultats, disciplines, noms, dates). C'est pour cette raison que vos réclamations ou annonces d'erreurs sont les bienvenue. Vous pouvez nous les signaler grâce au bouton bleu <em>Signaler une erreur</em> en haut à gauche de la page.</p>
```

## Deployment

Not yet

## Built With

* [MINI 2](https://github.com/panique/mini2) - The PHP framework used
* [Slim 3 Skeleton](https://github.com/aurmil/slim3-skeleton) - Architecture inspired from

## Contributing

* [Fork StatAthlé](https://help.github.com/articles/fork-a-repo/)
* Create your feature branch (git checkout -b my-new-feature)
* Make your changes
* Run the tests, adding new ones for your own code if necessary (phpunit)
* Commit your changes (git commit -am 'Added some feature')
* [Push to the branch](https://help.github.com/articles/pushing-to-a-remote/) (git push origin my-new-feature)
* Create new [Pull Request](https://help.github.com/articles/about-pull-requests/)

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/michaelravedoni/statathle/tags). 

## Authors

* **Michael Ravedoni** - *Initial work*, [michaelravedoni](https://github.com/michaelravedoni)

See also the list of [contributors](https://github.com/michaelravedoni/statathle/contributors) who participated in this project.

## License

This project is licensed under the MIT License, so feel free to use the project for everything you like. - see the [LICENSE.md](LICENSE.md) file for details.

## Roadmap

* [feature] Customisation
* [feature] I18n
* [bug] Queries optimisation
