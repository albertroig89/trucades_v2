<?php

use App\Models\Call;
use App\Models\Stat;
use App\Models\User;

test('the create call form is accessible by authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('calls.create'))
        ->assertStatus(200)
        ->assertViewIs('calls.create')
        ->assertViewHasAll(['clients', 'users', 'stats', 'nStat']);
});


test('a call can be stored', function () {
    $user = User::factory()->create();
    $stat = Stat::factory()->create();

    $this->actingAs($user)
        ->post(route('calls.store'), [
            'user_id' => $user->id,
            'stat_id' => $stat->id,
            'callinf' => 'Información de la llamada',
            'clientname' => 'Cliente Prueba',
            'clientphone' => '123456789'
        ])
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('calls', [
        'user_id' => $user->id,
        'stat_id' => $stat->id,
        'clientname' => 'Cliente Prueba'
    ]);
});


test('the edit call form is accessible', function () {
    $user = User::factory()->create();
    $call = Call::factory()->create();

    $this->actingAs($user)
        ->get(route('calls.edit', $call))
        ->assertStatus(200)
        ->assertViewIs('calls.edit')
        ->assertViewHasAll(['call', 'clients', 'users', 'stats']);
});


test('a call can be updated', function () {
    $user = User::factory()->create();
    $call = Call::factory()->create(['user_id' => $user->id]);
    $newStat = Stat::factory()->create();

    $this->actingAs($user)
        ->put(route('calls.update', $call), [
            'user_id' => $user->id,
            'stat_id' => $newStat->id,
            'callinf' => 'Información actualizada',
            'clientname' => 'Cliente Actualizado'
        ])
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('calls', [
        'id' => $call->id,
        'stat_id' => $newStat->id,
        'callinf' => 'Información actualizada',
        'clientname' => 'Cliente Actualizado'
    ]);
});


test('a call can be deleted', function () {
    $user = User::factory()->create();
    $call = Call::factory()->create();

    $this->actingAs($user)
        ->delete(route('calls.destroy', $call))
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseMissing('calls', ['id' => $call->id]);
});


test('job from call form is accessible', function () {
    $user = User::factory()->create();
    $call = Call::factory()->create();

    $this->actingAs($user)
        ->get(route('calls.jobfromcall', $call))
        ->assertStatus(200)
        ->assertViewIs('calls.jobfromcall')
        ->assertViewHasAll(['call', 'clients', 'users', 'stats', 'phones']);
});
