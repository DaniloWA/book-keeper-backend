<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

trait HtppResponseException
{
    protected function HttpResponseException(Validator $validator, $statusCode = 422)
    {
        throw new HttpResponseException(response()->json([
        'status' => "Error",
        'status_code' => $statusCode,
        'message' => $validator->errors()->all(),
        'data' => [],
        ], $statusCode));

    }
}
