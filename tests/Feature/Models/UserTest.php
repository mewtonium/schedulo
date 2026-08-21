<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Str;

test('a full name is returned correctly', function (string $first, string $last, string $expected) {
    $user = User::factory()->create([
        'first_name' => $first,
        'last_name' => $last,
    ]);

    expect($user->full_name)->toBe($expected);
})->with([
    'simple' => ['Joe', 'Bloggs', 'Joe Bloggs'],
    'hyphenated first name' => ['Anne-Marie', 'Smith', 'Anne-Marie Smith'],
    'hyphenated last name' => ['Sarah', 'Fletcher-Jones', 'Sarah Fletcher-Jones'],
    'apostrophe' => ['Niall', "O'Brien", "Niall O'Brien"],
    'curly apostrophe' => ['Niall', 'O’Brien', 'Niall O’Brien'],
    'accented characters' => ['Zoë', 'Müller', 'Zoë Müller'],
    'multi-part last name' => ['Piet', 'van der Berg', 'Piet van der Berg'],
    'multi-part first name' => ['J K', 'Rowling', 'J K Rowling'],
]);

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
