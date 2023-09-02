<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
            //
        });
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return JsonResponse
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            $error = 'Route not found';
            if ($e instanceof ModelNotFoundException){
                $modelName = class_basename($e->getModel());
                $error = "$modelName not found";
            }
            return errorResponse($error,[],null,[],Response::HTTP_NOT_FOUND);
        }
        elseif ($e instanceof ValidationException) {
            return errorResponse('Failed validation',[],$e->validator->errors(),[],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        elseif ($e instanceof AuthenticationException) {
            return errorResponse('Unauthorized',[],null, [],Response::HTTP_UNAUTHORIZED);
        }

        elseif ($e instanceof UnauthorizedHttpException) {
            return errorResponse('Unauthorized',[],null, [],Response::HTTP_UNAUTHORIZED);
        }

        elseif ($e instanceof ClientErrorException) {
            return errorResponse($e->getMessage(),[],null,[]);
        }

        elseif ($e instanceof ThrottleRequestsException) {
            return errorResponse('Max attempts exceeded.Retry later.',[],null,[],Response::HTTP_TOO_MANY_REQUESTS);
        }

        return errorResponse($e->getMessage(),[],null,[],Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
