<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidApiStatusException;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    protected string $status;
    protected null|string $message;
    protected int $statusCode;

    public function __construct($resource = [], string $status = "Success", null|string $message = 'Operation successful', int $statusCode = 200)
    {
        if (!in_array($status, ["Success", "Error"])) {
            throw new InvalidApiStatusException();
        }

        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function toArray($request): array
    {
        return [
            'status' => $this->status,
            'status_code' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->header('Content-Type', 'application/json');
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $response->header('X-User-Authenticated', auth::check() ? 1 : 0);
        $response->setStatusCode($this->statusCode);
        return;
    }
}
