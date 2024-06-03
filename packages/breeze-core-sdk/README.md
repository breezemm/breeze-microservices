# Breeze Core SDK (Internal)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/myanmarcyberyouths/breeze-core-sdk.svg?style=flat-square)](https://packagist.org/packages/myanmarcyberyouths/breeze-core-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/myanmarcyberyouths/breeze-core-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/myanmarcyberyouths/breeze-core-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/myanmarcyberyouths/breeze-core-sdk/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/myanmarcyberyouths/breeze-core-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/myanmarcyberyouths/breeze-core-sdk.svg?style=flat-square)](https://packagist.org/packages/myanmarcyberyouths/breeze-core-sdk)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

```bash
composer require myanmarcyberyouths/breeze-core-sdk
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="breeze-core-sdk-config"
```

## Authorization

Add the following to your config/auth.php file under guards section to enable breeze authorization.

```php
<?php


'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'breeze.authorizer',
    ]
],
```

Then you can use the following middleware to protect your routes.

```php
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
```

## Checking Scopes

Breeze SDK includes two middleware that may be used to verify that an incoming request is authenticated with a token
that
has been granted a given scope. To get started, define the following middleware aliases in your application's
`bootstrap/app.php` file:

```php
<?php

use  MyanmarCyberYouths\Breeze\Middleware\CheckScopes;
use  MyanmarCyberYouths\Breeze\Middleware\CheckForAnyScope;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'scopes' => CheckScopes::class,
        'scope' => CheckForAnyScope::class,
    ])
})
```

## Check For All Scopes

The `scopes` middleware may be assigned to a route to verify that the incoming request's access token has all of the
listed scopes:

```php

Route::get('/orders', function () {
// Access token has both "check-status" and "place-orders" scopes...
})->middleware(['auth:api', 'scopes:check-status,place-orders']);
```

## Check For Any Scopes

The `scope` middleware may be assigned to a route to verify that the incoming request's access token has at least one of
the listed scopes:

```php
Route::get('/orders', function () {
    // Access token has either "check-status" or "place-orders" scope...
})->middleware(['auth:api', 'scope:check-status,place-orders']);
```
