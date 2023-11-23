<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function handleQueryException(QueryException $exception)
    {
        $errorCode = $exception->errorInfo[1];
        if ($errorCode === 1062) {
            Session::flash('error', 'Contact No. already exists. please provide a new one');
            return redirect()->back();
            // } elseif ($errorCode === YourSpecificErrorCode) {
            //     Session::flash('error', 'Specific database error message.');
            //     // Handle other specific database error codes
            //     return redirect()->back();
        }

        // Default error handling for other database-related exceptions
        // Session::flash('error', 'An error occurred while processing your request.');
        Session::flash('error', $exception->getMessage());
        return redirect()->back();
    }
}
