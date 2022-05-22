<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * @var array
     */
    protected $dontReport = [];

    /**
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {});
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return Response|JsonResponse|SymfonyResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|SymfonyResponse
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return abort(404);
        }
        return parent::render($request, $e);
    }
}
