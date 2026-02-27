<?php

namespace App\Models;

use App\Enums\ProgressStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'data',
        'progress'
    ];

    protected $casts = [
        'data' => 'array',
        'progress' => 'float'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function status(): string
    {
        return ProgressStatus::fromProgress($this->progress)->value;
    }

    /**
     * document.data.items sum
     * @return int
     */
    public function segmentsCount(): int
    {
        return count($this->data);
    }

    /**
     * sum(document.data.items) * sum(project.target_languages_ids) 
     * @return int
     */
    public function totalSegments(): int
    {
        return $this->segmentsCount() * $this->project->languagesCount();
    }

    /**
     * sum of translated segments in translations.data * sum of target languages (all translated segments of all items in all target languages)
     * @return int
     */
    public function totalTranslatedSegments(): int
    {
        $translatedSegmentsCount = 0;

        foreach ($this->translations as $translation) {
            $translatedSegmentsCount +=  $translation->singleLangTranslatedSegmentsCount();
        }

        return $translatedSegmentsCount;
    }
}
