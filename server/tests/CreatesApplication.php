<?php

declare(strict_types = 1);

namespace Tests;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        RateLimiter::for('api', fn (Request $request) => Limit::none()
            ->by(optional($request->user())->id ?: $request->ip()));

        return $app;
    }
}
