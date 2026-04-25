<?php

namespace App\Http\Middleware\Project;

use App\Exceptions\Account\NoAccessToOperationException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectListAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd();
        if (!authUserId()) {
            throw new NoAccessToOperationException();
        }
        return $next($request);
    }
}
