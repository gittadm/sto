<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class ActiveMiddleware
{
    /**
     * @param $request
     * @param  Closure  $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        if ($request->wantsJson() && !user()->is_active) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
