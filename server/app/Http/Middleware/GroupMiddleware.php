<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   
    public function handle($request, Closure $next, $group)
    {
        if (! $request->user() || ! $request->user()->hasRole($group)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
