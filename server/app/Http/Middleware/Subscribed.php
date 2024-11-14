<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Subscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->subscribed()) {
        // Redirect user to billing page and ask them to subscribe...
        return redirect('/billing');
    }
        return $next($request);
    }
}
