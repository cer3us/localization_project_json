<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Default document (for standalone use) – will be overridden by relationships
            'document_id' => Document::factory(),

            // Language ID: pick a random target language from the document's project
            'language_id' => function (array $attributes) {
                $document = Document::with('project')->find($attributes['document_id']);
                if (!$document || !$document->project) {
                    // Fallback: random language (should not happen in seeded data)
                    return Language::inRandomOrder()->value('id');
                }

                $targetIds = $document->project->target_languages_ids ?? [];
                if (empty($targetIds)) {
                    return Language::inRandomOrder()->value('id');
                }

                return $targetIds[array_rand($targetIds)];
            },

            // Data: translate the document's source segments into the chosen language
            'data' => function (array $attributes) {
                $document = Document::with('project')->find($attributes['document_id']);
                if (!$document) {
                    // Fallback: random fake data
                    return [
                        ['key' => fake('ja_JP')->word, 'value' => fake('ja_JP')->sentence],
                    ];
                }

                $project = $document->project;
                $sourceLang = Language::find($project->source_language_id);
                $sourceLocale = $sourceLang?->locale ?? 'en';

                $targetLang = Language::find($attributes['language_id']);
                $targetLocale = $targetLang?->locale ?? 'en';

                $sourceData = $document->data ?? [];
                if (empty($sourceData)) {
                    return [];
                }

                $translated = [];
                foreach ($sourceData as $item) {
                    $translated[] = [
                        'key'   => $item['key'],
                        'value' => fake('en_US')->sentence()
                    ];
                }
                return $translated;

                //for using google-translate package:
                // $translated = [];
                // foreach ($sourceData as $item) {
                //     $translated[] = [
                //         'key'   => $item['key'],
                //         'value' => translate($item['value'], $targetLocale, $sourceLocale),
                //     ];
                // }
                //return $translated;

            },
        ];
    }
}
