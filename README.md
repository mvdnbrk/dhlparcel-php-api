This repo is a forked version of [mvdnbrk/dhlparcel-php-api](https://github.com/mvdnbrk/dhlparcel-php-api)
# DHL Parcel API client for PHP

![PHP version][ico-php-version]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![Code style][ico-code-style]][link-code-style]
[![Total Downloads][ico-downloads]][link-downloads]

[DHL Parcel API documentation](https://api-gw.dhlparcel.nl/docs/)

## Installation

You can install the package via composer:

```bash
composer require mvdnbrk/dhlparcel-php-api
```

## Usage

Initialize the DHL Parcel client and set your credentials.

``` php
$dhlparcel = new \Mvdnbrk\DhlParcel\Client();

$dhlparcel->setUserId('your-user-id');
$dhlparcel->setApiKey('your-api-key');
```

If you have multipe accounts, you may optionally set an account id:

```
$dhlparcel->setAccountId('123456');
```

### Create a parcel

```php
$parcel = new \Mvdnbrk\DhlParcel\Resources\Parcel([
    'reference' => 'your own reference for the parcel (optional)',
    'recipient' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'street' => 'Poststraat',
        'number' => '1',
        'number_suffix' => 'A',
        'postal_code' => '1234AA',
        'city' => 'Amsterdam',
        'cc' => 'NL',
    ],
    'sender' => [
        'company_name' => 'Your Company Name',
        'street' => 'Pakketstraat',
        'additional_address_line' => 'Industrie 9999',
        'number' => '99',
        'postal_code' => '9999AA',
        'city' => 'Amsterdam',
        'cc' => 'NL',
    ],
    // Optional. This will be set as the default.
    'pieces' => [
        [
            'parcel_type' => \Mvdnbrk\DhlParcel\Resources\Piece::PARCEL_TYPE_SMALL,
            'quantity' => 1,
        ],
    ],
]);
```

### Create the shipment

``` php
$shipment = $dhlparcel->shipments->create($parcel);

$shipment->id;
// For shipments with multiple pieces:
$shipment->pieces->each(function ($item) {
    $item->label_id;
    $item->barcode;
})
// For a shipment with one single piece:
$shipment->label_id;
$shipment->barcode;
```

### Retrieving a label

A label can be retrieved by using the `label_id`.
This will return a PDF label as a string.

```
$dhlparcel->labels->get($shipment->label_id);
```

Or you may pass the `Shipment` instance directly to this method:

```
$dhlparcel->labels->get($shipment);
```

> Passing a `Shipment` instance will only retrieve the label for a shipment with a single piece, or the first piece if you have created a shipment with multple pieces. If you have created a shipment with multiple pieces you should retrieve the labels one by one for each piece your shipment contains.

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
        'cash_on_delivery' => 9.95,
        'evening_delivery' => true,
        'extra_assurance' => true,
        ...
    ],
]);
```

Or you may use a method like `signature()` and others after constructing the parcel:

``` php
$parcel->onlyRecipient()
       ->signature()
       ->labelDescription('Order #123')
       ->cashOnDelivery(9.95)
       ->eveningDelivery()
       ->extraAssurance();
```

**Mailbox package**

If you would like to send a parcel that fits in a standard mailbox you may use the `mailboxpackage()` method:

``` php
$parcel->mailboxpackage();
```

**Deliver a parcel to a DHL service point**

You may send a parcel to a DHL service point where a customer can pick up the parcel.
The ID of the service point can be set directly when creating a parcel
or with the `servicePoint` method:

``` php
$parcel = new \Mvdnbrk\MyParcel\Resources\Parcel([
    ...
    'options' => [
        'service_point_id' => '8004-NL-272403',
        ...
    ],
]);

$parcel->servicePoint('8004-NL-272403');
```

### Tracking a shipment

``` php
$tracktrace = $dhlparcel->tracktrace->get('JVGL...');

// Check if the shipment is delivered:
$tracktrace->isDelivered;
```

### Retrieving service points

```php
$servicepoints = $dhlparcel->servicePoints->setPostalcode('1012AA')->setHousenumber('1')->get();
```

This will return a collection of `ServicePoint` objects:

```
$servicepoints->each(function ($item) {
    $item->id;
    $item->name;
    $item->latitude;
    $item->longitude;
    $item->distance;
    $item->distanceForHumans();
});
```

## Usage with Laravel

You may incorporate this package in your Laravel application by using [this package](https://github.com/mvdnbrk/laravel-dhlparcel).

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mark van den Broek](https://github.com/mvdnbrk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-php-version]: https://img.shields.io/packagist/php-v/mvdnbrk/dhlparcel-php-api?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/mvdnbrk/dhlparcel-php-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/workflow/status/mvdnbrk/dhlparcel-php-api/tests/main?label=tests&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mvdnbrk/dhlparcel-php-api.svg?style=flat-square
[ico-code-style]: https://styleci.io/repos/171006427/shield?branch=main

[link-packagist]: https://packagist.org/packages/mvdnbrk/dhlparcel-php-api
[link-tests]: https://github.com/mvdnbrk/dhlparcel-php-api/actions?query=workflow%3Atests
[link-downloads]: https://packagist.org/packages/mvdnbrk/dhlparcel-php-api
[link-author]: https://github.com/mvdnbrk
[link-contributors]: ../../contributors
[link-code-style]: https://styleci.io/repos/171006427
