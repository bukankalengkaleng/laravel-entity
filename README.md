# <img src="https://seeklogo.com/images/L/laravel-logo-9B01588B1F-seeklogo.com.png" width="24px"> Laravel Entity 🛸

[![Build Status](https://travis-ci.org/bukankalengkaleng/laravel-entity.svg?branch=master)](https://travis-ci.org/bukankalengkaleng/laravel-entity)

> This readme is written in Bahasa. [English version is here](https://github.com/bukankalengkaleng/laravel-entity/blob/master/README.EN.md).

## Deskripsi

*Artisan command* untuk membuat entitas yang lengkap.

## Motivasi

Membuat entitas (contoh: *Product, Employee*, dsb) yang lengkap (ada *Model, Factory, Migration, Form Requests, Feature / Unit tests, Policy*, dan *Controller*-nya) akan memakan waktu jika dilakukan manual. Artisan command ini akan mempercepatnya.

## Instalasi

### Langkah 1/2

`composer require bukankalengkaleng/laravel-entity`

Laravel v5.5 dan keatas akan otomatis meregistrasi package ini. Jika kamu menggunakan versi dibawah itu, kamu perlu melakukannya manual dalam file `config/app.php`:

```php
'providers' => [
    // ...
    BukanKalengKaleng\LaravelEntity\LaravelEntityServiceProvider::class,
];
```

### Langkah 2/2 (opsional)

Kamu bisa mem-*publish* file (`config`) dari package ini dengan cara:

`php artisan vendor:publish --tag="laravel-entity"`

## Cara Menggunakan

1. `php artisan entity:make Product`
1. Kamu akan dapati entitas **Product** yang lengkap:
    1. app/Models/**Product.php**
    1. database/migrations/**create_products_table.php**
    1. database/factories/**ProductFactory.php**
    1. database/seeds/**ProductsTableSeeder.php**
    1. database/seeds/dummies/**Products.php**
    1. app/Http/Controllers/Admin/**ProductController.php**
    1. app/Http/Controllers/Frontend/**ProductController.php**
    1. app/Http/Requests/Admin/**ProductStore.php**
    1. app/Http/Requests/Admin/**ProductUpdate.php**
    1. app/Http/Requests/Frontend/**ProductStore.php**
    1. app/Http/Requests/Frontend/**ProductUpdate.php**
    1. app/Policies/**ProductPolicy.php**
    1. app/tests/Feature/**ProductTest.php**
    1. app/tests/Unit/**ProductTest.php**

## Roadmap

Untuk mengetahui rencana kedepan package ini silahkan membaca [Roadmap](https://github.com/bukankalengkaleng/laravel-entity/blob/master/ROADMAP.md).

## Kontribusi

1. Kirim PR
1. Gak perlu baper kalo PR tertolak

## Catatan Revisi

Catatan revisi dapat dilihat di [Changelog](https://github.com/bukankalengkaleng/laravel-entity/blob/master/CHANGELOG.md) ini.

## Lisensi

Lisensi dari package ini adalah MIT License (MIT). Silahkan lihat bagian [Lisensi](https://github.com/bukankalengkaleng/laravel-entity/blob/master/LICENSE.md) ini untuk lebih jelasnya.
