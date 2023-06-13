# Technical-Test-01-Symfony

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/1ccbfe99d0844347a24a4eabc1313dec)](https://www.codacy.com/gh/if-web-dev/Openclassrooms-Project-06-Snowtricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=if-web-dev/Openclassrooms-Project-06-Snowtricks&amp;utm_campaign=Badge_Grade)

We present the first technical test with PHP/Symfony; Create a car dealership Symfony application. You can see the [Instructions here].

## To start

This project was developed with PHP 8.1, it integrates bootstrap 5, jquery, fontawesome libraries.

### Prerequisites

- A machine with at least PHP 8.1.
- Composer
- Symfony CLI

### Installation

- Clone or download the repository
- Duplicate and rename the `.env` file to `.env.local` and modify the necessary information and choose your database (`APP_ENV`, `APP_SECRET`, ...)
- Install the dependencies with `symfony composer install --optimize-autoloader`
- Run migrations with `symfony console doctrine:migrations:migrate --no-interaction`
- Add default datasets with `symfony console doctrine:fixtures:load --no-interaction`

## Startup

- Locally run your database
- Run the app with `symfony serve -d`

## Features

- Car Crud
- Car Pagination
- Car Search by name
- Car Category filter
- Weather Api feature + refreshed by Ajax avery hour
- Bootstrap v5

## Made with

* [Bootstrap](https://getbootstrap.com/) - Framework CSS (front-end)
* [Fontawesome](https://fontawesome.com/icons) - Icon Libarary (front-end)
* [JQuery](https://jquery.com/) - Framework Js (front-end)
* [Composer](https://getcomposer.org/) - Dependancy manager
* [Paginator](https://github.com/KnpLabs/KnpPaginatorBundle) - Symfony paginator library
* [Faker/pelmered/fake-car](https://github.com/pelmered/fake-car) - Faker provider for fake car data
* [Visual Studio code](https://code.visualstudio.com/) - Code editor

## Author

* **Ishake FOUHAL** _alias_ [@IF-WEB-DEV](https://github.com/if-web-dev)