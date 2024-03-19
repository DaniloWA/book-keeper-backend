<?php

namespace App\Traits;

use App\Http\Resources\ApiResponse;

trait ApiResponser
{
    protected function successResponse($data = [], string $message = null, int $code = 200): ApiResponse
    {
        return new ApiResponse($data, "Success", $message, $code);
    }

    protected function errorResponse(string $message, int $code, $data = []): ApiResponse
    {
        return new ApiResponse($data, "Error", $message, $code);
    }
}
