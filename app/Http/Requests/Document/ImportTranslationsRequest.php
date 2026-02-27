<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class ImportTranslationsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'lang' => ['required', 'int', 'exists:languages,id'],
            'data' => ['required', 'array'],
            'data.*.key' => ['required', 'string'],
            'data.*.value' => ['required', 'string'],
        ];
    }
}
