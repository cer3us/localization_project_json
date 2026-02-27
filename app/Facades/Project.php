<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Project extends Facade
{

    /**
     * @method static \App\Models\Project create(array $data)
     * @method static \App\Services\Account\ProjectService setProject(\App\Models\Project $project)
     * 
     * @see \App\Services\Account\ProjectService

     */

    protected static function getFacadeAccessor(): string
    {
        return 'project_service';
    }
}
