<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('password.confirm'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('auth/ConfirmPassword'),
    );
});

test('password confirmation requires authentication', function () {
    $response = $this->get(route('password.confirm'));

    $response->assertRedirect(route('login'));
});

test('confirming a password with no intended url redirects to the current team dashboard', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('password.confirm.store'), ['password' => 'password']);

    $response->assertRedirect(route('dashboard', ['current_team' => $user->personalTeam()->ulid]));

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->post(route('password.confirm.store'), ['password' => 'password'])
        ->assertOk();
});
