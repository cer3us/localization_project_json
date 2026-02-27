<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Translation extends Model
{
    /** @use HasFactory<\Database\Factories\TranslationFactory> */
    use HasFactory;

    protected $fillable = [
        'document_id',
        'language_id',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }


    /**
     * sum of translated segments in translations.data (of a single target language)
     * @return int
     */
    public function singleLangTranslatedSegmentsCount(): int
    {
        $translatedSegmentsCount = Arr::where($this->data, function ($item) {
            return !empty($item['value']) && is_string($item['value']);
        });

        return count($translatedSegmentsCount);
    }
}
