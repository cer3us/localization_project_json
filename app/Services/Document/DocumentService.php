<?php

namespace App\Services\Document;

use App\Models\Document;
use App\Models\Language;
use App\Models\Project;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DocumentService
{
    private Project $project;
    private Document $document;

    //accepts either a Project model instance or a project ID (integer):
    //If $project is already a Project instance (checked via instanceof), it uses that instance directly.
    //Otherwise, it treats $project as an integer ID, fetches the project from the database using findOrFail, and stores that model.
    //The findOrFail method throws a ModelNotFoundException if no project exists with that ID, which will become a 404 error if not caught. 
    public function setProject(Project|int $project): DocumentService
    {
        $this->project = $project instanceof Project
            ? $project
            : Project::query()->findOrFail($project);
        return $this;
    }

    public function setDocument(Document $document): DocumentService
    {
        $this->document = $document;
        return $this;
    }

    public function add(array $documents): DocumentService
    {
        $sourceLanguage = Language::find($this->project->source_language_id)?->locale;
        $targetLanguages = Language::whereIn('id', $this->project->target_languages_ids)
            ->pluck('locale', 'id');

        foreach ($documents as $docData) {
            // 1. Create the document and get the model instance
            $document = $this->project->documents()->create($docData);

            // 2. For each target language, generate and store translations
            foreach ($targetLanguages as $langId => $langLocale) {
                $translatedData = Arr::map($docData['data'], function ($el) use ($langLocale, $sourceLanguage) {
                    return [
                        'key'   => $el['key'],
                        'value' => translate($el['value'], $langLocale, $sourceLanguage)
                    ];
                });

                $document->translations()->create([
                    'language_id' => $langId,
                    'data'        => $translatedData
                ]);
            }

            // 3. Update this document's progress
            $this->setDocument($document)->updateDocumentProgress();
        }

        return $this;
    }

    public function list(): Collection
    {

        return $this->project->documents()->get();
    }

    public function getTranslations(int $lang)
    {
        $data = [
            'name' => $this->document->name,
            'data' => []
        ];

        $sourceData = Arr::map($this->document->data, function ($el) {
            return [
                'key' => $el['key'],
                'original' => $el['value'],
                'translation' => ''
            ];
        });

        $translations = Translation::query()
            ->where('language_id', $lang)
            ->where('document_id', $this->document->id)
            ->first();

        if (!is_null($translations)) {
            foreach ($sourceData as $item) {
                $targetItem = Arr::first($translations->data, function ($el) use ($item) {
                    return $el['key'] === $item['key'];
                });

                if (!is_null($targetItem)) {
                    $item['translation'] = $targetItem['value'];
                }

                $data['data'][] = $item;
            }
        } else {
            $data['data'][] = $sourceData;
        }

        return $data;
    }

    public function importTranslations(int $lang, array $translations)
    {

        $translatedData = [];

        $existingTranslation = Translation::query()
            ->where('language_id', $lang)
            ->where('document_id', $this->document->id)
            ->first();

        //`data` column in the document
        $sourceData = is_null($existingTranslation)
            //use original `document.data` if no tranlations were found:
            ? $this->document->data
            : $existingTranslation->data;

        foreach ($sourceData as $item) {
            //returns the first element  where `keys` in `translations` and `data.item` match
            $targetItem = Arr::first($translations, function ($el) use ($item) {
                return $el['key'] === $item['key'];
            });


            //if there is no match in the existing document.data, then keep the original state of `data.item` :
            if (is_null($targetItem)) {
                if (is_null($existingTranslation)) {
                    //to avoid keeping the non-translated text in the `translations`:
                    $item['value'] = '';
                }
            } else {
                //if there's a `key` match, than assign new value from the request to it:
                $item['value'] = $targetItem['value'];
            }
            $translatedData[] = $item;
        };

        Translation::query()->updateOrCreate([
            'language_id' => $lang,
            'document_id' => $this->document->id,
        ], [
            'data' => $translatedData
        ]);

        $this->updateDocumentProgress();
    }

    private function updateDocumentProgress(): void
    {
        // document.data.item * project.target_languages_ids = sum(items) = 100%
        $totalSegments = $this->document->totalSegments(); // 3 items * 3 langs = 9
        $totalTranslatedSegments = $this->document->totalTranslatedSegments();

        $currentProgress = round($totalTranslatedSegments * 100 / $totalSegments);
        $this->document->update([
            'progress' => $currentProgress
        ]);
    }
}
