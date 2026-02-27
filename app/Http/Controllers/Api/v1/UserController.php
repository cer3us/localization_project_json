<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account\UserResource;
use App\Models\User;

class UserController extends Controller
{

    public function list()
    {
        return UserResource::collection(User::all());
    }
}
