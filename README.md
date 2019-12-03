# EU Check Vat Service

A little PHP helper to check VAT numbers by an european service called VIES (VAT Information Exchange System).

## Getting Started

PHP 7 or above and Composer is expected to be installed on our system.

## Installing

```
composer require csoellinger/eu-check-vat-service
```

## Usage

```php
<?php

use EuCheckVatService\CheckVat;

// Full check (Return name and address if registered)
print_r((new CheckVat())->exec('AT', 'U65923833', true));

// Simple Check (Return only true or false)
var_dump((new CheckVat())->exec('AT', 'U65923833'));
```

## Example

See inside public dir for an example.


## Running the Tests

All tests can be run by executing

```
vendor/bin/phpunit
```

`phpunit` will automatically find all tests inside the `tests` directory and run them based on the configuration in the `phpunit.xml` file.


## Running the Example

PHP has an in-built server for local development. To run this change into the directory `public` and run

```
php -S localhost:8000
```

Then open your browser at `http://localhost:8000/example.php`


## Built With

- [PHP](https://secure.php.net/)
- [Composer](https://getcomposer.org/)
- [PHPUnit](https://phpunit.de/)

## License

This project is licensed under the MIT License - see the [LICENCE.md](LICENCE.md) file for details.
