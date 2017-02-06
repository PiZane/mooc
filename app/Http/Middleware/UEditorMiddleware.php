<?php

namespace App\Http\Middleware;

use Closure;

class UEditorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth('teacher')->check()) {
            abort(500);
        }
        return $next($request);
    }
}
