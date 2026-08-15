<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Laravel\Telescope\Telescope;
use Symfony\Component\HttpFoundation\Response;

final class TelescopeTheme
{
    /**
     * Layer Telescope's dark stylesheet on top of the light one, applied only
     * when the visitor's operating system asks for a dark colour scheme.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $response = $next($request);

        if (! $response instanceof HttpResponse) {
            return $response;
        }

        $content = $response->getContent();

        if (! is_string($content) || ! str_contains($content, '</head>')) {
            return $response;
        }

        $styles = $this->darkStyles();

        if ($styles === null) {
            return $response;
        }

        $nonceAttribute = Telescope::$nonceAttribute;

        return $response->setContent(str_replace(
            '</head>',
            "<style media=\"(prefers-color-scheme: dark)\"{$nonceAttribute}>{$styles}</style></head>",
            $content,
        ));
    }

    /**
     * Read Telescope's dark theme stylesheet from its published assets.
     */
    protected function darkStyles(): ?string
    {
        $path = base_path('vendor/laravel/telescope/dist/styles-dark.css');

        $styles = is_readable($path) ? @file_get_contents($path) : false;

        return $styles ?: null;
    }
}
