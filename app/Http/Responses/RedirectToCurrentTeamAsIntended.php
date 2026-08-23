<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Http\Responses\Concerns\RedirectsToCurrentTeam;
use Illuminate\Contracts\Support\Responsable;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

final class RedirectToCurrentTeamAsIntended implements Responsable
{
    use RedirectsToCurrentTeam;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct(public string $name)
    {
        //
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toResponse($request): Response
    {
        return redirect()->intended(
            $this->redirectPathForCurrentTeam($request, Fortify::redirects($this->name)),
        );
    }
}
