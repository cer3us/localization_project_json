<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class AssignPerformerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'projectId' => ['required', 'int', 'exists:projects,id'],
            'performerId' => ['required', 'int', 'exists:users,id']
        ];
    }
}
