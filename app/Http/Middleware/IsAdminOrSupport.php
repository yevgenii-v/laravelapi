<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class IsAdminOrSupport
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('sanctum')->user()->roles->containsStrict('id', Role::IS_ADMIN) ||
            auth('sanctum')->user()->roles->containsStrict('id', Role::IS_SUPPORT)) {
            return $next($request);
        }
        return response(['message' => 'Page not found'], 404);
    }
}
