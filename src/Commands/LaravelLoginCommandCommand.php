<?php

namespace CaesarDev\LaravelLoginCommand\Commands;

use Illuminate\Console\Command;

class LaravelLoginCommandCommand extends Command
{
    public $signature = 'laravel-login-command';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
