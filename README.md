# Enumer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ronildo-sousa/enumer.svg?style=flat-square)](https://packagist.org/packages/ronildo-sousa/enumer)
[![Total Downloads](https://img.shields.io/packagist/dt/ronildo-sousa/enumer.svg?style=flat-square)](https://packagist.org/packages/ronildo-sousa/enumer)
<!--- [![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ronildo-sousa/enumer/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ronildo-sousa/enumer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ronildo-sousa/enumer/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ronildo-sousa/brasilapi-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)-->

A simple package to create PHP enum from a Json.

## Installation

You can install the package via composer:

```bash
composer require ronildo-sousa/enumer
```

## Usage

```php
$json = '{"Hearts": "H", "Diamonds": "D", "Clubs": "C", "Spades": "S"}';

$enumer = new RonildoSousa\Enumer();
$enumer->convertJson(json: $json, file_path: '/Enums/Test.php');
```

It will create a class like this:

```php
enum Test: string
{
    
   case Hearts = "H";

   case Diamonds = "D";

   case Clubs = "C";

   case Spades = "S";

}
```

You can change the return type of the enum:

```php
$json = '{"Guest": 1, "Editor": 2, "Admin": 3, "Owner": 4}';

$enumer = new RonildoSousa\Enumer();
$enumer->convertJson(json: $json, file_path: '/Enums/Test.php', returnType: 'int');
```

It will create a class like this:

```php
enum Test: int
{
    
   case Guest = 1;

   case Editor = 2;

   case Admin = 3;

   case Owner = 4;

}
```

## Testing

```bash
composer test
```

## Credits

- [Ronildo Sousa](https://github.com/Ronildo-Sousa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
