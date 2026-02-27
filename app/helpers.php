<?php

use Illuminate\Http\JsonResponse;
use Stichoza\GoogleTranslate\GoogleTranslate;


function responseOk($data): JsonResponse
{
    return response()->json([
        'status' => 'success',
        'data' => $data
    ], 200);
}

function responseCreated($data): JsonResponse
{
    return response()->json([
        'status' => 'success',
        'data' => $data
    ], 201);
}

function authUserId(): ?int
{
    return auth()->id();
}

//free version of `tanmuhittin/laravel-google-translate` package translation:s 
if (!function_exists('translate')) {
    function translate(string $text, string $target, string $source = 'en'): string
    {
        return (new GoogleTranslate())
            ->setSource($source)
            ->setTarget($target)
            ->translate($text);
    }
}
