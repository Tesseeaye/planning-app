<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
{
    parent::setUp();

    // Ensure the environment is set to testing
    if (app()->environment() !== 'testing') {
        throw new \Exception('Not running in testing environment');
    }
}
}