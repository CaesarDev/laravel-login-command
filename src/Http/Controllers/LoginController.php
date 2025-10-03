<?php

namespace CaesarDev\LaravelLoginCommand\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Invalid or expired login link.');
        }

        $userId = $request->query('user');
        $guard = $request->query('guard', config('login-command.guard'));

        $user = $this->findUser($userId, $guard);

        if (! $user) {
            abort(404, 'User not found.');
        }

        Auth::guard($guard)->login($user);

        $redirectUrl = $request->query('redirect', config('login-command.redirect_url', '/'));

        return redirect($redirectUrl);
    }

    protected function findUser($userId, $guard)
    {
        $userModel = config("auth.guards.{$guard}.provider");
        $provider = config("auth.providers.{$userModel}.model");

        if (! $provider) {
            $provider = config('login-command.user_model', 'App\\Models\\User');
        }

        return $provider::find($userId);
    }
}
