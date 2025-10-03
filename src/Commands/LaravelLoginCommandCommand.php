<?php

namespace CaesarDev\LaravelLoginCommand\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class LaravelLoginCommandCommand extends Command
{
    public $signature = 'login:link 
                        {user? : The ID or email of the user}
                        {--guard= : The authentication guard to use}
                        {--redirect= : The URL to redirect to after login}
                        {--expires= : The number of minutes the link is valid for}';

    public $description = 'Generate a signed login link for a user';

    public function handle(): int
    {
        $userIdentifier = $this->argument('user') ?? $this->ask('Enter user ID or email');

        if (! $userIdentifier) {
            $this->error('User identifier is required.');

            return self::FAILURE;
        }

        $user = $this->findUser($userIdentifier);

        if (! $user) {
            $this->error('User not found.');

            return self::FAILURE;
        }

        $guard = $this->option('guard') ?? config('login-command.guard') ?? config('auth.defaults.guard');
        $redirect = $this->option('redirect') ?? config('login-command.redirect_url', '/');
        $expires = $this->option('expires') ?? config('login-command.expiration', 60);

        $url = URL::temporarySignedRoute(
            config('login-command.route_name', 'login-link'),
            now()->addMinutes($expires),
            [
                'user' => $user->id,
                'guard' => $guard,
                'redirect' => $redirect,
            ]
        );

        $this->info('Login link generated successfully!');
        $this->newLine();
        $this->line($url);
        $this->newLine();
        $this->comment("This link will expire in {$expires} minutes.");

        return self::SUCCESS;
    }

    protected function findUser($identifier)
    {
        $userModel = config('login-command.user_model', 'App\\Models\\User');

        if (is_numeric($identifier)) {
            return $userModel::find($identifier);
        }

        return $userModel::where('email', $identifier)->first();
    }
}
