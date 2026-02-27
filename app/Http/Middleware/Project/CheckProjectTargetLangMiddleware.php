<?php

namespace App\Http\Middleware\Project;

use App\Exceptions\Project\InvalidLanguageException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectTargetLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $document = $request->route('document');
        $project = $document->project;
        $languageId = $request->input('lang');

        if (!$project->hasLang($languageId)) {
            throw new InvalidLanguageException();
        }

        return $next($request);
    }
}
