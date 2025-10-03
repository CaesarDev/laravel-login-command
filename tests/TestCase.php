<?php

namespace CaesarDev\LaravelLoginCommand\Tests;

use CaesarDev\LaravelLoginCommand\LaravelLoginCommandServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\TestCase as Orchestra;

#[WithMigration]
class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => match (true) {
                str_starts_with($modelName, 'Workbench\\') => 'Workbench\\Database\\Factories\\'.class_basename($modelName).'Factory',
                default => 'CaesarDev\\LaravelLoginCommand\\Database\\Factories\\'.class_basename($modelName).'Factory',
            }
        );
    }

    protected function tearDown(): void
    {
        if (
            method_exists(\Illuminate\Foundation\Bootstrap\HandleExceptions::class, 'flushHandlersState') &&
            $this->app
        ) {
            try {
                \Illuminate\Foundation\Bootstrap\HandleExceptions::flushHandlersState($this);
            } catch (\Throwable $e) {
            }
        }
        
        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelLoginCommandServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        $app['config']->set('auth.defaults.guard', 'web');
        $app['config']->set('auth.providers.users.model', \Workbench\App\Models\User::class);
        $app['config']->set('login-command.user_model', \Workbench\App\Models\User::class);

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }
}
