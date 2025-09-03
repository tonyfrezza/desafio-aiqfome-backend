<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException || $exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Rota não encontrada'
            ], 404);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => 'Acesso negado'
            ], 403);
        }

        return parent::render($request, $exception);
    }

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {});
    }
}
