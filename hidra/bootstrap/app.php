<?php

use App\Domain\Shared\Exceptions\ExcecaoDeDominio;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (ExcecaoDeDominio $e): JsonResponse {
            $codigo = $e->codigo()->value;

            return new JsonResponse(
                data: ['error' => ['code' => $codigo, 'message' => __('errors.'.$codigo)]],
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        });

        $exceptions->render(function (InvalidArgumentException $e): JsonResponse {
            $codigo = $e->getMessage();

            return new JsonResponse(
                data: ['error' => ['code' => $codigo, 'message' => __('errors.'.$codigo)]],
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        });
    })->create();

$app->useAppPath($app->basePath('src'));

return $app;
