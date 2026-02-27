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
            // Default project_id for standalone usage (will be overridden when used via relationship)
            // 'project_id' => Project::factory(),

            // Generate name using the project's source language locale
            //The $attributes parameter in the closure is automatically provided by Laravel's factory system when the closure is evaluated
            'name' => function (array $attributes) {
                $project = Project::find($attributes['project_id']);
                $locale = Language::find($project->source_language_id)?->locale ?? 'en';
                return fake($locale)->sentence(4);
            },

            // Generate data segments in the same source language
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
