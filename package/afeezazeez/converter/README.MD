#  Price Calculator


## Description

This package empowers international users by enabling them to effortlessly determine the price of individual products or calculate the total cart amount in their preferred currency, offering a seamless shopping experience tailored to their currency preferences

## Installation

You can install the package via Composer:

Note: This is not necessary as package has been required as local dependency

```
composer require afeezazeez/converter
```


## Publish Configuration

```
php artisan vendor:publish --provider="Afeezazeez\Converter\Providers\ConverterServiceProvider" --tag="config"
```

## Usage

You can convert using the ExchangeConverter Facade which is readily available

```
 <?php

namespace App\Http\Controllers;


class ConvertController extends Controller
{
    public function check(){
         $amount = ExchangeConverter::convert(100,'USD');
         return $amount;
    }
}

```
You can convert by directly calling the endpoint on postman like below

```
 http://localhost:8000/api/v1/exchange?amount=100&currency=USD
```

## Testing
You can run the package tests using:

```
composer test
```

## Security
If you discover any security-related issues, please email [azeezafeez212@gmail.com](mailto:azeezafeez212@gmail.com) instead of using the issue tracker.

## Credits
[Afeez Azeez](https://github.com/afeezazeez)

