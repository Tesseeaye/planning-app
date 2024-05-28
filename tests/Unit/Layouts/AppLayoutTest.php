<?php

use App\View\Components\AppLayout;
use Livewire\Livewire;

test('renders', function () {
    $component = new AppLayout;

    $renderedView = $component->render();

    expect($renderedView->name())->toBe('layouts.app');
});
