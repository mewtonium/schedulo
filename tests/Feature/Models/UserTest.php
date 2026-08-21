<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Str;

describe('ulid', function () {
    test('a ulid is stored against a new user', function () {
        $user = User::factory()->create();

        expect(Str::isUlid($user->ulid))->toBeTrue();
    });

    test('the ulid has not changed when updating a user', function () {
        $user = User::factory()->create();
        $ulid = $user->ulid;

        $user->update(['first_name' => 'Example']);

        expect($user->fresh()->ulid)->toBe($ulid);
    });

    test('the ulid is immutable once a user has been created', function () {
        $user = User::factory()->create();
        $ulid = $user->ulid;

        $user->update(['ulid' => 'some-new-value']);

        expect($user->fresh()->ulid)->toBe($ulid);
    });
});
