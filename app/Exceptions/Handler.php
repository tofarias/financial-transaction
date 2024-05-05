<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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

    /** Register the exception handling callbacks for the application. */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {

            if ($request->is('api/*') === false) {
                return;
            }

            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response['message'] = $e->getMessage();

            if($e instanceof DomainException) {
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            }

            if($e->getPrevious() instanceof ModelNotFoundException) {
                $status = Response::HTTP_NOT_FOUND;
                $response['message'] = 'Resource not found';
            }

            if(config('app.debug') === true) {
                if(App::environment('local')) {
                    $response = array_merge($response, [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            }

            return response()->json($response, $status);
        });
    }
}
