<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create client request passes validation with all fields', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('clients.store'), [
            'name' => 'Bertito tito',
            'email' => 'bertito@example.com',
            'phone' => '123456789',
            'phones' => ['987654321', '456123789'],  // Teléfonos adicionales
        ])
        ->assertSessionHasNoErrors();
});

test('create client request fails if required fields are missing', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('clients.store'), [
            'name' => '',
            'phone' => '',
        ])
        ->assertSessionHasErrors(['name', 'phone']);
});

test('create client request fails if email is invalid or already exists', function () {
    $existingClient = Client::factory()->create(['email' => 'existing@example.com']);

    // Email inválido
    $this->actingAs(User::factory()->create())
        ->post(route('clients.store'), [
            'name' => 'Bertito tito',
            'email' => 'invalid-email',
            'phone' => '123456789',
        ])
        ->assertSessionHasErrors('email');

    // Email ya existente
    $this->actingAs(User::factory()->create())
        ->post(route('clients.store'), [
            'name' => 'Bertito tito',
            'email' => 'existing@example.com',
            'phone' => '123456789',
        ])
        ->assertSessionHasErrors('email');
});


test('create client request fails if phones are not valid', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('clients.store'), [
            'name' => 'Bertito Tito',
            'phone' => '123456789',
            'phones' => ['not-a-phone', 12345],  // Teléfonos no válidos
        ])
        ->assertSessionHasErrors(['phones.0', 'phones.1']);  // Validamos ambos índices del array
});



test('create client request passes if additional phones are empty or not provided', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('clients.store'), [
            'name' => 'Bertito tito',
            'email' => 'bertito@example.com',
            'phone' => '123456789',
            'phones' => [],  // Sin teléfonos adicionales
        ])
        ->assertSessionHasNoErrors();

    $this->actingAs(User::factory()->create())
        ->post(route('clients.store'), [
            'name' => 'Bertito',
            'email' => 'bertito2@example.com',
            'phone' => '123456789',
            // phones no está presente
        ])
        ->assertSessionHasNoErrors();
});
