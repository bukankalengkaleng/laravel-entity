# Laravel Entity 🧱

Readme ini ditulis dalam bahasa Inggris. [Versi bahasa Indonesianya ada disini.](README.md)

|     | Status |
| --- | --- |
| Release | [![Latest Stable Version](https://poser.pugx.org/bukankalengkaleng/laravel-entity/v/stable)](https://packagist.org/packages/bukankalengkaleng/laravel-entity) [![Total Downloads](https://poser.pugx.org/bukankalengkaleng/laravel-entity/downloads)](https://packagist.org/packages/bukankalengkaleng/laravel-entity) [![License](https://poser.pugx.org/bukankalengkaleng/laravel-entity/license)](https://packagist.org/packages/bukankalengkaleng/laravel-entity) |
| Code Quality | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-entity/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-entity/?branch=master) [![codecov](https://codecov.io/gh/bukankalengkaleng/laravel-entity/branch/master/graph/badge.svg)](https://codecov.io/gh/bukankalengkaleng/laravel-entity) [![Code Intelligence Status](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-entity/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence) |
| Development | [![Build Status](https://travis-ci.org/bukankalengkaleng/laravel-entity.svg?branch=master)](https://travis-ci.org/bukankalengkaleng/laravel-entity) [![Maintainability](https://api.codeclimate.com/v1/badges/e0369d6cc9799b353c0a/maintainability)](https://codeclimate.com/github/bukankalengkaleng/laravel-entity/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/e0369d6cc9799b353c0a/test_coverage)](https://codeclimate.com/github/bukankalengkaleng/laravel-entity/test_coverage) |

---

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

The entity's namespaces (`Admin` and `Frontend`) are configurable via the `config/entity.php` file, which you have to publish first:

```
php artisan vendor:publish --tag="laravel-entity"
```

## Screenshots

<img src="screenshots/01.png" width="45%"> <img src="screenshots/02.png" width="45%">

## Roadmap

All planning goes to [Roadmap](ROADMAP.md) file.

## Contributing [![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/bukankalengkaleng/laravel-entity/issues)

1. Send PR
1. Please do not take it personal if your PR got rejected

## Changelog

Notable changes are documented in [Changelog](CHANGELOG.md) file.

## License

The MIT License (MIT). Please see [License](LICENSE.md) file for more information.
