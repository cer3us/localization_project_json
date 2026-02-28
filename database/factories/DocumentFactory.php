<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'name' => function (array $attributes) {
                $project = Project::find($attributes['project_id']);
                $locale = Language::find($project->source_language_id)?->locale ?? 'en';
                return fake($locale)->sentence(4);
            },

            'data' => function (array $attributes) {
                $project = Project::find($attributes['project_id']);
                $locale = Language::find($project->source_language_id)?->locale ?? 'en';
                $faker = fake($locale);

                return [
                    ['key' => 'title',       'value' => $faker->sentence(3)],
                    ['key' => 'description', 'value' => $faker->paragraph()],
                    ['key' => 'body',        'value' => $faker->text(200)],
                ];
            },
        ];
    }
}
