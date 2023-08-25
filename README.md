# laravel-telegram-api
Laravel PHP package use to manage budget statement income and expend of project.

## Installation
You can install the package via composer:
```bash
composer require cambodev/statement
```

## Configuration
##### Laravel 5.5 and above
You don't have to do anything else, this package autoloads the Service Provider and create the Alias, using the new Auto-Discovery feature.
Add the Service Provider and Facade alias to your config/app.php

##### Laravel 5.4 and below
```php
CamboDev\Statement\StatementServiceProvider::class,
```

## Publish
```php
php artisan vendor:publish --provider="Cambodev\Statement\Provider\StatementServiceProvider"
```

## License
CamboDev is licensed under the MIT License
