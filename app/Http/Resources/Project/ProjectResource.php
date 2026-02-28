<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Document\MinifiedDocumentResource;
use App\Http\Resources\Language\LanguageResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'progress' => 0,
            'languages' => [
                'source' => new LanguageResource($this->sourceLanguage),
                'target' => LanguageResource::collection($this->targetLanguages())
            ],
            'documents' => MinifiedDocumentResource::collection($this->documents),
            'performers' => GetPerformersResource::collection($this->performers),
            'settings' => [
                'useMachineTranslation' => $this->use_machine_translation
            ],
            'createdAt' => Carbon::parse($this->created_at)->format('d-m-Y H:i')
        ];
    }
}
