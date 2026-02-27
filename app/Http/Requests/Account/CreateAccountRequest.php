<?php

namespace App\Http\Requests\Account;

use App\Enums\AccountType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;


class CreateAccountRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            //email should be unique in `users` table/`email` column:
            'email' => ['required', 'email', 'unique:users,email'],

            //Method 2:
            'accountType' => ['required', 'string', new Enum(AccountType::class)],

            //'companyName' => ['required_unless:accountType,ltd']
            'companyName' => ['required_if:accountType,' . AccountType::LTD->value],

            'password' => ['required', 'required_array_keys:value,confirmation'],
            'password.value' => ['required', 'min:8', 'max:100'],
            'password.confirmation' => ['same:password.value']
        ];
    }
}
