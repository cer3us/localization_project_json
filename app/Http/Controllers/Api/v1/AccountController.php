<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CreateAccountRequest;
use App\Facades\Account;
use App\Http\Requests\Account\SignInRequest;
use App\Http\Resources\Account\UserResource;

class AccountController extends Controller
{
    public function create(CreateAccountRequest $request)
    {

        $user = Account::create($request->validated());

        return responseCreated($user);
    }

    public function signIn(SignInRequest $request)
    {
        $data = $request->validated();

        $token = Account::signIn(
            $data['email'],
            $data['password']
        );

        return [
            'token' => $token
        ];
    }

    //returns currently authenticated user(with a token):
    public function show()
    {
        return new UserResource(auth()->user());
    }
}
