<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'source_language_id',
        'user_id',
        'target_languages_ids',
        'use_machine_translation'
    ];

    protected $casts = [
        'target_languages_ids' => 'array',
        'use_machine_translation' => 'bool'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sourceLanguage()
    {
        return $this->belongsTo(Language::class, 'source_language_id');
    }

    public function targetLanguages(): Collection
    {
        return Language::query()
            ->whereIn('id', $this->target_languages_ids)
            ->get();
    }

    public function hasLang(int $language_id): bool
    {
        return in_array($language_id, $this->target_languages_ids);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function performers(): HasMany
    {
        return $this->hasMany(Performer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'performers');
    }

    public function hasAccess(): bool
    {
        return $this->user_id === authUserId();
    }

    public function languagesCount(): int
    {
        return count($this->target_languages_ids);
    }
}
