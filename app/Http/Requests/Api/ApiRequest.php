<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\ObjectRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class ApiRequest
 */
abstract class ApiRequest extends ObjectRequest
{
    /**
     * @inheritDoc
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json($validator->errors());
        $response->setStatusCode(422);

        throw new HttpResponseException($response);
    }
}
