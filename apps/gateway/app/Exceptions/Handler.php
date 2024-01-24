<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('v1/events/*')) {
                return json_response(404, 'Resource not found', null)->setStatusCode(404);
            }

            return null;
        });

    }

    public function render($request, Throwable $exception)
    {
//        if ($exception instanceof ModelNotFoundException) {
//            return json_response(404, str_replace('App\\Models\\', '', $exception->getModel()) . ' not found', null)->setStatusCode(404);
//        }


        return parent::render($request, $exception);
    }
}
