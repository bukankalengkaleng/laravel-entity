# <img src="https://seeklogo.com/images/L/laravel-logo-9B01588B1F-seeklogo.com.png" width="24px"> Laravel Entity 🛸

[![Build Status](https://travis-ci.org/bukankalengkaleng/laravel-entity.svg?branch=master)](https://travis-ci.org/bukankalengkaleng/laravel-entity)

> Readme ini ditulis dalam bahasa Inggris. [Versi bahasa Indonesianya ada disini](https://github.com/bukankalengkaleng/laravel-entity/blob/master/README.md).

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

The entity's namespaces (`Admin` and `Frontend`) are configurable via the `config/entity.php` file, which you can publish:

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
