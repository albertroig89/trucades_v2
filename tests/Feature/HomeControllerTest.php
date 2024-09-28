<?php

use App\Models\User;
use App\Models\Call;
use App\Models\Department;
use App\Models\Stat;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->artisan('migrate:fresh --seed');
});

test('dashboard is accessible by authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertStatus(200)
        ->assertViewIs('dashboard');
});

test('redirects to mobile view if user prefers mobile', function () {
    $user = User::factory()->create(['desktop' => false]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertStatus(200)
        ->assertViewIs('mobile-dashboard');
});

test('calls are paginated based on department and user', function () {
    $user = User::factory()->create();
    $department = Department::factory()->create(['title' => 'Tecnico']);
    $user->update(['department_id' => $department->id]);

    $globalUser = User::factory()->create(['name' => 'Global']);
    $call = Call::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertStatus(200)
        ->assertViewHas('calls')
        ->assertSee($call->id);
});

test('admin users can see all calls', function () {
    $user = User::factory()->create();
    $department = Department::factory()->create(['title' => 'Administración']);
    $user->update(['department_id' => $department->id]);

    $call = Call::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertStatus(200)
        ->assertViewHas('allcalls', true)
        ->assertSee($call->id);
});


test('can change view preference to desktop', function () {
    $user = User::factory()->create(['desktop' => false]);

    $this->actingAs($user)
        ->post(route('changeViewPreference'), ['desktop' => true])
        ->assertRedirect(route('dashboard'));

    expect($user->fresh()->desktop)->toBeTrue();
});

test('can change view preference to mobile', function () {
    $user = User::factory()->create(['desktop' => true]);

    $this->actingAs($user)
        ->post(route('changeViewPreference'), ['desktop' => false])
        ->assertRedirect(route('dashboard'));

    expect($user->fresh()->desktop)->toBeFalse();
});

test('fails if invalid desktop preference is provided', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('changeViewPreference'), ['desktop' => 'invalid'])
        ->assertSessionHasErrors(['desktop']);
});

