<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (UnauthorizedException $e, $request) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 403);
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'error' => true,
                'message' => 'Page not found'
            ], 404);
        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'error' => true,
                'message' => 'Method not allowed'
            ], 404);
        });
    }
}
