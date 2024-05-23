<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (Throwable $exception) {
            if (request()->is('api')) {
                if ($exception instanceof ModelNotFoundException)
                    return response()->json(['error' => 'Resource Not Found'], 404);
                else if ($exception instanceof ValidationException)
                    return response()->json(['error' => 'Data Not Valid'], 400);
                else if (isset ($exception)) {
                    return response()->json(['error' => 'Error: ' . $exception->getMessage()], 500);
                }
            }
        });
    }
}
