<p align="center"><img src="screenshots/logo.png" width="50%"></p>

<p align="center">Readme ini ditulis dalam bahasa Inggris. <a href="https://github.com/bukankalengkaleng/laravel-entity/blob/master/README.md">Versi bahasa Indonesianya ada disini</a>.</p>

---

| Development | Code Quality | Release | 
| :---------: | :----------: | :-----: |
| [![Build Status](https://travis-ci.org/bukankalengkaleng/laravel-entity.svg?branch=master)](https://travis-ci.org/bukankalengkaleng/laravel-entity) <br> [![Maintainability](https://api.codeclimate.com/v1/badges/e0369d6cc9799b353c0a/maintainability)](https://codeclimate.com/github/bukankalengkaleng/laravel-entity/maintainability) <br> [![Test Coverage](https://api.codeclimate.com/v1/badges/e0369d6cc9799b353c0a/test_coverage)](https://codeclimate.com/github/bukankalengkaleng/laravel-entity/test_coverage) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-entity/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-entity/?branch=master) <br> [![codecov](https://codecov.io/gh/bukankalengkaleng/laravel-entity/branch/master/graph/badge.svg)](https://codecov.io/gh/bukankalengkaleng/laravel-entity) <br> [![Code Intelligence Status](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-entity/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence) | [![Total Downloads](https://poser.pugx.org/bukankalengkaleng/laravel-entity/downloads)](https://packagist.org/packages/bukankalengkaleng/laravel-entity) <br> [![Latest Stable Version](https://poser.pugx.org/bukankalengkaleng/laravel-entity/v/stable)](https://packagist.org/packages/bukankalengkaleng/laravel-entity) <br> [![License](https://poser.pugx.org/bukankalengkaleng/laravel-entity/license)](https://packagist.org/packages/bukankalengkaleng/laravel-entity) | 

## Description

An artisan command to generate a complete entity.

## Motivation

Creating an entity (*eg: Product, Employee, etc*) that has a complete artefact (*Model, Factory, Migration, Form Requests, Feature / Unit tests, Policy, and Controller*) could take a time and boring. This artisan command will make it faster.

## Installation

```
composer require bukankalengkaleng/laravel-entity
```

In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

```php
'providers' => [
    // ...
    BukanKalengKaleng\LaravelEntity\LaravelEntityServiceProvider::class,
];
```

## Usage

1. Run `entity:make` artisan command
    ```
    php artisan entity:make Product
    ```
1. You will get a complete **Product** entity:
    - app/Models/**Product.php**
    - database/migrations/**create_products_table.php**
    - database/factories/**ProductFactory.php**
    - database/seeds/**ProductsTableSeeder.php**
    - database/seeds/dummies/**Products.php**
    - app/Http/Controllers/Admin/**ProductController.php**
    - app/Http/Controllers/Frontend/**ProductController.php**
    - app/Http/Requests/Admin/**ProductStore.php**
    - app/Http/Requests/Admin/**ProductUpdate.php**
    - app/Http/Requests/Frontend/**ProductStore.php**
    - app/Http/Requests/Frontend/**ProductUpdate.php**
    - app/Policies/**ProductPolicy.php**
    - app/tests/Feature/**ProductTest.php**
    - app/tests/Unit/**ProductTest.php**

    <img src="screenshots/01.png" width="45%"> <img src="screenshots/02.png" width="45%">

The entity's namespaces (`Admin` and `Frontend`) are configurable via the `config/entity.php` file, which you have to publish first:

```
php artisan vendor:publish --tag="laravel-entity"
```

## Roadmap

All planning goes to [Roadmap](https://github.com/bukankalengkaleng/laravel-entity/blob/master/ROADMAP.md) file.

## Contributing

1. Send PR
1. Please do not take it personal if your PR got rejected

## Changelog

Notable changes are documented in [Changelog](https://github.com/bukankalengkaleng/laravel-entity/blob/master/CHANGELOG.md) file.

## License

The MIT License (MIT). Please see [License](https://github.com/bukankalengkaleng/laravel-entity/blob/master/LICENSE.md) file for more information.
