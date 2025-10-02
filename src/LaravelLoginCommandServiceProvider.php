<?php

namespace CaesarDev\LaravelLoginCommand;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use CaesarDev\LaravelLoginCommand\Commands\LaravelLoginCommandCommand;

class LaravelLoginCommandServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-login-command')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_login_command_table')
            ->hasCommand(LaravelLoginCommandCommand::class);
    }
}
