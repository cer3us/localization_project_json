<?php

namespace App\Http\Middleware\Document;

use App\Exceptions\Account\NoAccessToOperationException;
use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetDocumentMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $project = Project::query()
            ->find($request->get('projectId'));

        //if project already exists, but `user_id doesn't match` than operation is forbidden:
        if (!is_null($project) && !$project->hasAccess()) {
            throw new NoAccessToOperationException();
        };

        return $next($request);
    }
}
