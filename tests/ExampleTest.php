<?php

use Illuminate\Support\Facades\URL;
use Workbench\App\Models\User;

it('generates a login link', function () {
    User::factory()->create();

    $expectedUrl = 'https://example.com/login-link?user=1&guard=web&redirect=%2F&signature=abc123';

    URL::shouldReceive('temporarySignedRoute')
        ->once()
        ->with(
            'login-link',
            \Mockery::type(\Illuminate\Support\Carbon::class),
            [
                'user' => 1,
                'guard' => 'web',
                'redirect' => '/',
            ]
        )
        ->andReturn($expectedUrl);

    $this->artisan('login:link', ['user' => 1])
        ->expectsOutput('Login link generated successfully!')
        ->expectsOutput($expectedUrl)
        ->assertSuccessful();
});
