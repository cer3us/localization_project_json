<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Language;
use App\Models\Performer;
use App\Models\Project;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Language::factory(5)
            ->create();
        Project::factory(10)
            ->has(Document::factory(1)->has(Translation::factory(2)))
            ->has(Performer::factory(10))
            ->create();
    }
}
