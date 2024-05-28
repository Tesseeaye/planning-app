<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Actions\Socialstream\SetUserPassword;

test('validates and updates the user\'s password', function () {
    $user = User::factory()->create();

    $action = new SetUserPassword;

    $action->set($user, [
        'password' => 'new-password',
        'password_confirmation' => 'new-password'
    ]);

    expect(Hash::check('new-password', $user->getAuthPassword()))->toBeTrue();
});