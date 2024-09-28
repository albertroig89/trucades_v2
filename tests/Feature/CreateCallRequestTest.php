<?php

use App\Models\Client;
use App\Models\User;
use App\Models\Stat;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create call request passes validation with all fields', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();

    $this->actingAs($user)
        ->post(route('calls.store'), [
            'user_id' => $user->id,
            'stat_id' => $stat->id,
            'callinf' => 'Información de la llamada',
            'clientname' => 'Nombre del cliente',
            'clientphone' => '123456789',
        ])
        ->assertSessionHasNoErrors();
});

test('create call request fails if required fields are missing', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('calls.store'), [])
        ->assertSessionHasErrors(['user_id', 'stat_id', 'callinf', 'clientname']);
});

test('create call request fails if clientphone is required but not provided', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();

    $this->actingAs($user)
        ->post(route('calls.store'), [
            'user_id' => $user->id,
            'stat_id' => $stat->id,
            'callinf' => 'Información de la llamada',
            'clientname' => 'Nombre del cliente',
            'clientphone' => null,  // Aquí se omite el teléfono, debe fallar si client_id no está presente
        ])
        ->assertSessionHasErrors(['clientphone']);
});


test('create call request fails if clientphone is not provided and client_id is null', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();

    $this->actingAs($user)
        ->post(route('calls.store'), [
            'user_id' => $user->id,
            'stat_id' => $stat->id,
            'callinf' => 'Información de la llamada',
            'clientname' => 'Nombre del cliente',
            // Aquí se omite client_id y clientphone, debe fallar la validación
        ])
        ->assertSessionHasErrors(['clientphone']);
});

test('create call request passes if client_id is provided and clientphone is not required', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();
    $client = Client::factory()->create();  // Crear un cliente válido

    $this->actingAs($user)
        ->post(route('calls.store'), [
            'user_id' => $user->id,
            'stat_id' => $stat->id,
            'client_id' => $client->id,  // Usar el ID del cliente creado
            'callinf' => 'Información de la llamada',
            'clientname' => 'Nombre del cliente',
            // Aquí omitimos clientphone, pero no debería ser obligatorio ya que client_id está presente
        ])
        ->assertSessionHasNoErrors();
});



test('create call request fails if client_id is provided but clientphone is invalid', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();

    $this->actingAs($user)
        ->post(route('calls.store'), [
            'user_id' => $user->id,
            'stat_id' => $stat->id,
            'callinf' => 'Información de la llamada',
            'clientname' => 'Nombre del cliente',
            'clientphone' => 12345, // No es una cadena de texto válida
        ])
        ->assertSessionHasErrors(['clientphone']);
});
