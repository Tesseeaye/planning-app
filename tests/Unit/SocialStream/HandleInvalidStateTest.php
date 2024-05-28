<?php

use App\Actions\Socialstream\HandleInvalidState;
use Laravel\Socialite\Two\InvalidStateException;

test('can handle invalid state', function () {
    $handler = new HandleInvalidState;

    $exception = Mockery::mock(InvalidStateException::class);

    $this->expectException(InvalidStateException::class);

    $handler->handle($exception);
});