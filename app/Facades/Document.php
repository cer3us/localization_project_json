<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Document extends Facade
{

    /**
     * @method static \App\Services\Document\DocumentService add(array $documents)
     * @method static \App\Services\Document\DocumentService setProject(\App\Models\Project|int $project)
     * @method static \App\Services\Document\DocumentService setDocument(\App\Models\Document $document)
     * 
     * @see \App\Services\Account\DocumentService

     */

    protected static function getFacadeAccessor(): string
    {
        return 'document_service';
    }
}
