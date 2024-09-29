<?php

use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('create user request passes validation with all fields', function () {
    $department = Department::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('users.store'), [
            'name' => 'Bertito tito',
            'email' => 'bertito@example.com',
            'password' => 'password123',
            'department_id' => $department->id,
            'avatar' => UploadedFile::fake()->image('avatar.jpg', 100, 100),
        ])
        ->assertSessionHasNoErrors();
});

test('create user request fails if required fields are missing', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('users.store'), [
            'name' => '',
            'email' => '',
            'password' => '',
            'department_id' => '',
        ])
        ->assertSessionHasErrors(['name', 'email', 'password', 'department_id']);
});

test('create user request fails if email is invalid or already exists', function () {
    $department = Department::factory()->create();
    $existingUser = User::factory()->create(['email' => 'existing@example.com']);

    // Email inválido
    $this->actingAs(User::factory()->create())
        ->post(route('users.store'), [
            'name' => 'Bertito tito',
            'email' => 'invalid-email',
            'password' => 'password123',
            'department_id' => $department->id,
        ])
        ->assertSessionHasErrors('email');

    // Email ya existente
    $this->actingAs(User::factory()->create())
        ->post(route('users.store'), [
            'name' => 'Jane Doe',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'department_id' => $department->id,
        ])
        ->assertSessionHasErrors('email');
});

test('create user request fails if avatar is not an image', function () {
    $department = Department::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post(route('users.store'), [
            'name' => 'Bertito tito',
            'email' => 'bertito@example.com',
            'password' => 'password123',
            'department_id' => $department->id,
            'avatar' => UploadedFile::fake()->create('not-an-image.pdf', 100),
        ])
        ->assertSessionHasErrors('avatar');
});


