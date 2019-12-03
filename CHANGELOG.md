# Changelog

All notable changes to `dhlparcel-php-api` will be documented in this file.

## [Unreleased]

## [v0.8.0] - 2019-12-03

### Added
- Added `pieces` to the `Shipments` resource. [`#37`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/37)
- Added `barcode` alias for `tracker_code` on the `ShipmentPiece` resource. [`#38`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/38)

### Changed
- Refactored `Pieces` resource to  a`PiecesCollection`. [`#35`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/35)

## [v0.7.0] - 2019-11-14

### Removed
- Removed support for Laravel. Please use this [package](https://github.com/mvdnbrk/laravel-dhlparcel) instead. [`#16`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/16) 

## [v0.6.2] - 2019-11-14

### Added
- Added `ShipmentPiece` resource. [`#10`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/29)

## [v0.6.1] - 2019-11-13

### Fixed
- Make sure `quantity` and `weight` are integer values. [`#27`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/27)

## [v0.6.0] - 2019-11-13

### Added
- Added `ext-json` as a requirement. [`#23`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/23)

### Changed
- Changed `addPiece` method to `add` in the `Pieces` class. [`#19`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/19)
- Changed `company` to an alias for `company_name` in the `Recipient` class. [`#13`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/13)

## [v0.5.0] - 2019-11-11

### Added
- Added ability to set `pieces` for a parcel. [`#10`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/10)

## [v0.4.1] - 2019-11-11

### Changed
- Updated dependencies.

### Fixed
- Fixed missing import. [`484b5d4`](https://github.com/mvdnbrk/dhlparcel-php-api/commit/484b5d43c9f5b3ae90baa034642a91ab2e4a3f0b)

## [v0.4.0] - 2019-10-08

### Changed
- Dropped support for PHP version 7.1.
- Updated dependencies.

## [v0.3.4] - 2019-04-12

### Added
- Added `setAccountId` method. [`#8`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/8)

## [v0.3.3] - 2019-03-20

- Fixed ServicePoint toArray(). [`a46bd0a`](https://github.com/mvdnbrk/dhlparcel-php-api/commit/a46bd0a18cbd5bca6c80b2332eb068b7b5f4777a)

## [v0.3.2] - 2019-03-20

### Fixed
- Fixed use statement. [`4b9006f`](https://github.com/mvdnbrk/dhlparcel-php-api/commit/4b9006f8e718b344d520cff8560a406cfa9d06ba)

## [v0.3.1] - 2019-03-20

### Changed
- The `toArray` method on a `ServicePoint` object has changed. [`#7`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/7)

## [v0.3.0] - 2019-03-19

### Added
- Added an option to send a parcel to a service point. [`#6`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/6)
- Added an endpoint to retrieve service point locations. [`#5`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/5)
- Added an `addition` alias to set a number suffix for an address. [`#4`](https://github.com/mvdnbrk/dhlparcel-php-api/pull/4)

## [v0.2.0] - 2019-03-15

### Added
- Added Track & Trace endpoint. [`cea132d`](https://github.com/mvdnbrk/dhlparcel-php-api/commit/cea132dc316a683ecc8289f9c964eb8cdc9d47b1)

## [v0.1.2] - 2019-02-23

### Fixed
- Convert a shipment to an array correctly. [`91b2cb73`](https://github.com/mvdnbrk/dhlparcel-php-api/commit/91b2cb73af77a097b596f950c48aa03705890f78)

## [v0.1.1] - 2019-02-23

### Fixed
- Fixed class import. [`bf990c4`](https://github.com/mvdnbrk/dhlparcel-php-api/commit/bf990c4447acae78e96f21a6cd49e57f45eb30dd)

## [v0.1.0] - 2019-02-22

### Initial release

[Unreleased]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.8.0...HEAD
[v0.8.0]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.7.0...v0.8.0
[v0.7.0]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.6.2...v0.7.0
[v0.6.2]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.6.1...v0.6.2
[v0.6.1]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.6.0...v0.6.1
[v0.6.0]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.5.0...v0.6.0
[v0.5.0]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.4.1...v0.5.0
[v0.4.1]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.4.0...v0.4.1
[v0.4.0]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.3.4...v0.4.0
[v0.3.4]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.3.3...v0.3.4
[v0.3.3]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.3.2...v0.3.3
[v0.3.2]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.3.1...v0.3.2
[v0.3.1]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.3.0...v0.3.1
[v0.3.0]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.2.0...v0.3.0
[v0.2.0]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.1.2...v0.2.0
[v0.1.2]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.1.1...v0.1.2
[v0.1.1]: https://github.com/mvdnbrk/dhlparcel-php-api/compare/v0.1.0...v0.1.1
[v0.1.0]: https://github.com/mvdnbrk/dhlparcel-php-api/tree/v0.1.0
