<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Check if the exception is an HTTP exception
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();

            if ($statusCode == 404) {
                // For 404 errors, return the custom 404 view
                Log::error('Custom 404 page triggered.');

                return response()->view('errors.404', [], 404);
            }
        }

        // Use the default handling for other exceptions
        return parent::render($request, $exception);
    }
}
