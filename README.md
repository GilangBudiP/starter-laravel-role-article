# Laravel

A starter kit of laravel with some simple features

## Features

- User Management with built in Role and Permission
- Articles
- Upload image for gallery

## Installation

Dillinger requires PHP v8.0+ to run.

Install the dependencies.
```sh
composer install
```

copy the .env file and generate key app
```sh
cp .env.example .env
php artisan key:generate
```

migrate the table and seed data
```sh
php artisan key:generate
php artisan migrate --seed
```

## Plugins

starter-laravel-role-article is currently extended with the following plugins.
Instructions on how to use them in your own application are linked below.

| Plugin | Link Docs |
| ------ | ------ |
| coderflexx/laravisit | [https://github.com/coderflexx/laravisit][PlGh] |
| cviebrock/eloquent-sluggable | [https://github.com/cviebrock/eloquent-sluggable][PlGh] |
| ralphjsmit/laravel-seo | [https://github.com/ralphjsmit/laravel-seo][PlGd] |
| spatie/laravel-medialibrary | [https://spatie.be/docs/laravel-medialibrary/v10/introduction][PlGh] |
| spatie/laravel-permission | [https://spatie.be/docs/laravel-permission/v6/introduction][PlGh] |
| spatie/laravel-searchable | [https://github.com/spatie/laravel-searchable][PlGh] |
| spatie/laravel-sitemap | [https://github.com/spatie/laravel-sitemap][PlGh] |
