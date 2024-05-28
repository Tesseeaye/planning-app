<?php

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ConnectedAccount;
use Laravel\Socialite\Two\User as OAuth2User;
use App\Actions\Socialstream\UpdateConnectedAccount;
use JoelButcher\Socialstream\RefreshedCredentials;
use JoelButcher\Socialstream\Socialstream;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->connectedAccount = ConnectedAccount::factory()->for($this->user)->create([
        'provider' => 'github',
    ]);
});

test('can update connected account', function () {
    $action = new UpdateConnectedAccount;

    $providerUser = new OAuth2User;
    $providerUser->id = '1234567890';
    $providerUser->name = 'Jane Doe';
    $providerUser->email = 'jane@example.com';
    $providerUser->token = Str::random(64);
    $providerUser->refreshToken = Str::random(64);
    $providerUser->expiresIn = 0;

    $response = $action->update($this->user, $this->connectedAccount, 'github', $providerUser);

    expect($response)->toBe($this->connectedAccount);
});

test('can refresh token for connected account', function () {
    Socialstream::refreshesTokensForProviderUsing('github', function () {
       return new RefreshedCredentials(
        'new-token',
        null,
        'new-refresh-token',
        now()->addSeconds(3600),
       );
    });

    $action = new UpdateConnectedAccount;

    $response = $action->updateRefreshToken($this->connectedAccount);

    expect($response)->toBe($this->connectedAccount);
});