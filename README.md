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
