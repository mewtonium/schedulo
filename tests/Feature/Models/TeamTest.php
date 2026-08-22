<?php

declare(strict_types=1);

use App\Models\Team;
use Illuminate\Support\Str;

describe('ulid', function () {
    test('a ulid is stored against a new team', function () {
        $team = Team::factory()->create();

        expect(Str::isUlid($team->ulid))->toBeTrue();
    });

    test('the ulid has not changed when updating a team', function () {
        $team = Team::factory()->create();
        $ulid = $team->ulid;

        $team->update(['name' => 'My Team']);

        expect($team->fresh()->ulid)->toBe($ulid);
    });

    test('the ulid is immutable once a team has been created', function () {
        $team = Team::factory()->create();
        $ulid = $team->ulid;

        $team->update(['ulid' => 'some-new-value']);

        expect($team->fresh()->ulid)->toBe($ulid);
    });
});
