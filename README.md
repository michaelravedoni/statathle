A statistics web app for athletics organisations

# StatAthle


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
Give examples
```

### Requirements

- PHP 5.3+
- MySQL
- mod_rewrite activated, document root routed to /public (tutorial below)

### Installing

A step by step series of examples that tell you have to get a development env running

Say what the step will be

```
Give the example
```

And repeat

```
until finished
```

End with an example of getting some data out of the system or using it for a little demo

## Deployment

Add additional notes about how to deploy this on a live system

## Configuration

Index.php holds the configs for a development environment. Self-explaining.

```php
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'debug' => true,
        'database' => array(
            'db_host' => 'localhost',
            'db_port' => '',
            'db_name' => 'stats',
            'db_user' => 'root',
            'db_pass' => '12345678'
        )
    ));
});
```

## Built With

* [MINI 2](https://github.com/panique/mini2) - The PHP framework used

## Contributing



## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/michaelravedoni/statathle/tags). 

## Authors

* **Michael Ravedoni** - *Initial work* - [michaelravedoni](https://github.com/michaelravedoni)

See also the list of [contributors](https://github.com/michaelravedoni/statathle/contributors) who participated in this project.

## License

This project is licensed under the MIT License, so feel free to use the project for everything you like. - see the [LICENSE.md](LICENSE.md) file for details.

## Roadmap

* [feature] Config file
* [feature] Customisation
* [feature] I18n
* [bug] Queries optimisation
