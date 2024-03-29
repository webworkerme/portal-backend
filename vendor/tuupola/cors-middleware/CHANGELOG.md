# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## [0.9.2](https://github.com/tuupola/cors-middleware/compare/0.9.1...0.9.2) - 2010-01-26
### Fixed
- Do not assume `error` and `methods` callables are an instance of a `Closure` ([#26](https://github.com/tuupola/cors-middleware/issues/26)).

## [0.9.1](https://github.com/tuupola/cors-middleware/compare/0.9.0...0.9.1) - 2018-10-15
### Added
- Support for `tuupola/callable-handler:^1.0` and `tuupola/http-factory:^1.0`

### Changed
- `neomerx/cors-psr7:^1.0.4` is now minimum requirement.

## [0.9.0](https://github.com/tuupola/cors-middleware/compare/0.8.0...0.9.0) - 2018-08-21
### Added
- New option `origin.server` to specify the origin of the server. Helps when same-origin requests include a valid but unesseccary `Origin` header ([#22](https://github.com/tuupola/cors-middleware/pull/22), [#23](https://github.com/tuupola/cors-middleware/pull/23)).

## [0.8.0](https://github.com/tuupola/cors-middleware/compare/0.7.0...0.8.0) - 2018-08-07
### Added
- Support for the stable version of PSR-17

### Changed
- Use released version of [equip/dispatch](https://github.com/equip/dispatch) in tests.

## [0.7.0](https://github.com/tuupola/cors-middleware/compare/0.6.0...0.7.0) - 2017-01-25
### Added
- Support for the [approved version of PSR-15](https://github.com/php-fig/http-server-middleware).

## [0.6.0](https://github.com/tuupola/cors-middleware/compare/0.5.2...0.6.0) - 2017-12-25
### Added
- Support for the [latest version of PSR-15](https://github.com/http-interop/http-server-middleware).
- Methods setting can now be either an array or callable returning an array. This is useful if your framework makes it possible to retrieve defined methods for a given route.

    ```php
    $app->add(new \Tuupola\Middleware\CorsMiddleware([
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    ]));
    ```
    ```php
    $app->add(new \Tuupola\Middleware\CorsMiddleware([
        "methods" => function(ServerRequestInterface $request) {
            /* Some logic to figure out allowed $methods. */
            return $methods;
        }
    ]));
    ```

### Changed
- Classname changed from Cors to CorsMiddleware.
- Settings can now be passed only in the constructor.
- PHP 7.1 is now minimum requirement.
- Inside error handler `$this` now refers to the middleware itself.
- PSR-7 double pass is now supported using [tuupola/callable-handler](https://github.com/tuupola/callable-handler) library.

### Removed
- Support for PHP 5.X. PSR-15 is now PHP 7.x only.
- Public getters and setters for the settings.

## [0.5.2](https://github.com/tuupola/cors-middleware/compare/0.5.1...0.5.2) - 2016-08-12

### Fixed
- Middleware was overriding the passed in response ([#1](https://github.com/tuupola/cors-middleware/issues/1)).

## [0.5.1](https://github.com/tuupola/cors-middleware/compare/0.5.0...0.5.1) - 2016-04-25
### Fixed
- Diactoros was erroring with integer header values.

## 0.5.0 - 2016-04-25
Initial release. Support PSR-7 style doublepass middlewares.
