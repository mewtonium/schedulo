<?php

declare(strict_types=1);

namespace App\Data;

final readonly class UserTeam
{
    public function __construct(
        public string $ulid,
        public string $name,
        public bool $isPersonal,
        public ?string $role,
        public ?string $roleLabel,
        public ?bool $isCurrent = null,
    ) {
        //
    }
}
