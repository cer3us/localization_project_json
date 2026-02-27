<?php

namespace App\Http\Middleware\Project;

use App\Exceptions\Account\NoAccessToOperationException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectAccessMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $project = $request->route('project');
        if (!$project->hasAccess()) {
            throw new NoAccessToOperationException();
        }

        return $next($request);
    }
}
