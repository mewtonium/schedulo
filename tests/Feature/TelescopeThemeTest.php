<?php

use App\Http\Middleware\TelescopeTheme;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

it('injects the dark theme styles along with the light theme styles', function () {
    $response = (new TelescopeTheme)->handle(
        Request::create('/telescope'),
        fn () => new Response('<html><head><style>light</style></head><body></body></html>'),
    );

    $content = $response->getContent();

    expect($content)->toContain('<style media="(prefers-color-scheme: dark)">')
        ->and($content)->toContain(file_get_contents(base_path('vendor/laravel/telescope/dist/styles-dark.css')))
        ->and($content)->toContain('</style></head>')
        ->and($content)->toContain('<style>light</style>');
});
