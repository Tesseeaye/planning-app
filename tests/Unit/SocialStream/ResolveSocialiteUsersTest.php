<?php

use Laravel\Socialite\Contracts\User;
use JoelButcher\Socialstream\Socialstream;
use App\Actions\Socialstream\ResolveSocialiteUser;
use JoelButcher\Socialstream\Contracts\ResolvesSocialiteUsers;
use Laravel\Socialite\Facades\Socialite;

test('the action can be overridden', function (): void {
    expect($this->app->make(ResolvesSocialiteUsers::class))
        ->toBeInstanceOf(ResolveSocialiteUser::class);

    Socialstream::resolvesSocialiteUsersUsing(ResolverOverride::class);

    expect($this->app->make(ResolvesSocialiteUsers::class))
        ->toBeInstanceOf(ResolverOverride::class);
});

class ResolverOverride implements ResolvesSocialiteUsers
{
    public function resolve(string $provider): User
    {
        $user = Socialite::driver($provider)->user();

        if (Socialstream::generatesMissingEmails()) {
            $user->email = $user->getEmail() ?? ("{$user->id}@{$provider}".config('app.domain'));
        }

        return $user;
    }
}
