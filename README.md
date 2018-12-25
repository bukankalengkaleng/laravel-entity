# <img src="https://seeklogo.com/images/L/laravel-logo-9B01588B1F-seeklogo.com.png" width="24px"> Laravel Entity 🛸

> This readme is written in Bahasa. [English version is here](https://github.com/bukankalengkaleng/laravel-entity/blob/master/README.EN.md).

## Deskripsi

*Artisan command* untuk membuat entitas yang lengkap.

## Motivasi

Membuat entitas (contoh: *Product, Employee*, dsb) yang lengkap (ada *Model, Factory, Migration, Form Requests, Feature / Unit tests, Policy*, dan *Controller*-nya) akan memakan waktu jika dilakukan manual. Artisan command ini akan mempercepatnya.

## Instalasi

`composer require bukankalengkaleng/laravel-entity`

Laravel v5.5 dan keatas akan otomatis meregistrasi package ini. Jika kamu menggunakan versi dibawah itu, kamu perlu melakukannya manual dalam file `config/app.php`:

```php
'providers' => [
    // ...
    BukanKalengKaleng\LaravelEntity\LaravelEntityServiceProvider::class,
];
```

## Cara Menggunakan

blablabla..

## Roadmap

Untuk mengetahui rencana kedepan package ini silahkan membaca [Roadmap]((https://github.com/bukankalengkaleng/laravel-entity/blob/master/ROADMAP.md)).

## Kontribusi

1. Kirim PR
1. Gak perlu baper kalo PR tertolak

## Catatan Revisi

Catatan revisi dapat dilihat di [Changelog](https://github.com/bukankalengkaleng/laravel-entity/blob/master/CHANGELOG.md) ini.

## Lisensi

Lisensi dari package ini adalah MIT License (MIT). Silahkan lihat bagian [Lisensi](https://github.com/bukankalengkaleng/laravel-entity/blob/master/LICENSE.md) ini untuk lebih jelasnya.
