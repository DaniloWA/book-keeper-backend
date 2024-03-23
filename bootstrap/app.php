<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Mockery\Exception\InvalidOrderException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/v1/api.php',
        apiPrefix: 'api/v1',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ForceJsonResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReportDuplicates();

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return (new ApiResponse(
                [],
                "Error",
                "You are not authenticated",
                401
            ))->response();
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return (new ApiResponse(
                [],
                "Error",
                $e->getMessage(),
                $e->getStatusCode()
            ))->response();
        });

        $exceptions->render(function (RouteNotFoundException $e, Request $request) {
            return (new ApiResponse(
                [],
                "Error",
                $e->getMessage(),
                404
            ))->response();
        });
    })->create();
