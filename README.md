# dhlparcel-php-api

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

[DHL Parcel API documentation](https://api-gw.dhlparcel.nl/docs/)

## Installation

You can install the package via composer:

```bash
composer require mvdnbrk/dhlparcel-php-api
```

## Getting started

Initialize the DHL Parcel client and set your credentials.

``` php
$dhlparcel = new \Mvdnbrk\DhlParcel\Client();

$dhlparcel->setUserId('your-user-id');
$dhlparcel->setApiKey('your-api-key');
```

### Create a parcel

```php
$parcel = new \Mvdnbrk\DhlParcel\Resources\Parcel([
    'reference' => 'your own reference for the parcel',
    'recipient' => [
        'first_name' => 'John',
        'last_name' => 'Doe'
        'street' => 'Poststraat',
        'number' => '1',
        'number_suffix' => 'A',
        'postal_code' => '1234AA',
        'city' => 'Amsterdam',
        'cc' => 'NL',
    ],
    'sender' => [
        'company_name' => 'Your Company',
        'street' => 'Pakketstraat',
        'number' => '99',
        'postal_code' => '9999AA',
        'city' => 'Amsterdam',
        'cc' => 'NL',
    ]
]);
```

### Create the shipment

``` php
$shipment = $dhlparcel->shipments->create($parcel);

$shipment->id;
$shipment->label_id;
$shipment->barcode;
```

You have created your first shipment!

### Retrieving a label

A label can be retrieved by using the `label_id`.
This will return a PDF label as a string.

```
$dhlparcel->labels->get($shipment->label_id);
```
Or you may pass the `Shipment` instance directly to this method:
```
$myparcel->labels->get($shipment);
```

### Setting delivery options for a parcel

You can set delivery options for a parcel by passing in the options directly when you create a parcel:

``` php
$parcel = new \Mvdnbrk\MyParcel\Resources\Parcel([
    ...
    'recipient' => [
        ...
    ],
    'options' => [
        'description' => 'Order #123',
        'signature' => true,
        'only_recipient' => true,   
        ...
    ],
]);
```

Or you may use a method like `signature()`, `onlyRecipient()` and `labelDescription()`.  
You may call any of these after constructing the parcel.

``` php
$parcel->onlyRecipient()
       ->signature()
       ->labelDescription('Order #123');
```

**Mailbox package**

If you would like to send a parcel that fits in a standard mailbox you may use the `mailboxpackage()` method:

``` php
$parcel->mailboxpackage();
```

## Usage with Laravel

Add your credentials to the `.env` file:

```
DHLPARCEL_ID=YOUR-USER-ID
DHLPARCEL_SECRET=YOUR-SECRET-KEY
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email mvdnbrk@gmail.com instead of using the issue tracker.

## Credits

- [Mark van den Broek](https://github.com/mvdnbrk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mvdnbrk/dhlparcel-php-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mvdnbrk/dhlparcel-php-api/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mvdnbrk/dhlparcel-php-api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mvdnbrk/dhlparcel-php-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mvdnbrk/dhlparcel-php-api.svg?style=flat-square
[ico-style-ci]: https://styleci.io/repos/171006427/shield?branch=master

[link-packagist]: https://packagist.org/packages/mvdnbrk/dhlparcel-php-api
[link-travis]: https://travis-ci.org/mvdnbrk/dhlparcel-php-api
[link-scrutinizer]: https://scrutinizer-ci.com/g/mvdnbrk/dhlparcel-php-api/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mvdnbrk/dhlparcel-php-api
[link-downloads]: https://packagist.org/packages/mvdnbrk/dhlparcel-php-api
[link-author]: https://github.com/mvdnbrk
[link-contributors]: ../../contributors
[link-style-ci]: https://styleci.io/repos/171006427
