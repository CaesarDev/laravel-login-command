# A Laravel command to login as a user
A Laravel package that generates secure, signed login links for authenticating users via the command line. Perfect for development, testing, or providing customer support access.

## Installation

You can install the package via composer:

```bash
composer require caesardev/laravel-login-command
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="login-command-config"
```

This is the contents of the published config file:

```php
return [
    'expiration' => 60,

    'guard' => null,

    'redirect_url' => '/',

    'route_name' => 'login-link',

    'user_model' => 'App\\Models\\User',
];
```

## Usage

Generate a signed login link for a user by their ID:

```bash
php artisan login:link 1
```

Or by their email:

```bash
php artisan login:link user@example.com
```

The command will output a signed URL that you can click or copy and paste into your browser to authenticate as that user.

### Options

**--guard**: Specify the authentication guard to use
```bash
php artisan login:link 1 --guard=admin
```

**--redirect**: Specify where to redirect after login
```bash
php artisan login:link 1 --redirect=/dashboard
```

**--expires**: Set how many minutes the link remains valid (default: 60)
```bash
php artisan login:link 1 --expires=120
```

### Configuration

- **expiration**: Default number of minutes the login link is valid (default: 60)
- **guard**: Default authentication guard to use (default: null, uses default guard)
- **redirect_url**: Default URL to redirect to after login (default: '/')
- **route_name**: Name of the login route (default: 'login-link')
- **user_model**: The User model class to use (default: 'App\\Models\\User')

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [hapidjus](https://github.com/hapidjus)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
