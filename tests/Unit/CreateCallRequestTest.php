<?php

use App\Models\User;
use App\Models\Stat;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('create call request passes validation', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();

    $data = [
        'user_id' => $user->id,
        'client_id' => null,
        'stat_id' => $stat->id,
        'callinf' => 'Información de la llamada',
        'clientname' => 'Nombre del cliente',
        'clientphone' => '123456789',
    ];

    $this->post(route('calls.store'), $data)
        ->assertSessionHasNoErrors();
});

test('create call request fails if required fields are missing', function () {
    $this->post(route('calls.store'), [])
        ->assertSessionHasErrors(['user_id', 'stat_id', 'callinf', 'clientname']);
});

test('create call request fails if clientphone is required but not provided', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();

    $data = [
        'user_id' => $user->id,
        'client_id' => null,
        'stat_id' => $stat->id,
        'callinf' => 'Información de la llamada',
        'clientname' => 'Nombre del cliente',
    ];

    $this->post(route('calls.store'), $data)
        ->assertSessionHasErrors(['clientphone']);
});
