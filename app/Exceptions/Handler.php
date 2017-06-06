<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        switch (true) {
            case $exception instanceof HttpException:
                return $this->convertHttpExceptionToResponse($exception, $request);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson() || $request->is('api/*')
                    ? response()->json(['message' => 'Unauthenticated.'], 401)
                    : redirect()->guest(route('login'));
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertHttpExceptionToResponse(HttpException $e, $request)
    {
        $message = $e->getMessage();
        $message = is_string($message) && $message === '' ? null : $message;

        if (is_null($message)) {
            switch ($e->getStatusCode()) {
                case 403:
                    $message = 'You don\'t have permission to access this endpoint!';
                    break;
                case 404:
                    $message = 'Endpoint not found!';
                    break;
                case 405:
                    $message = 'Method not allowed!';
                    break;
                default:
                    $message = 'Something went wrong!';
                    break;
            }
        }

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => $message], $e->getStatusCode());
        }

        return $this->prepareResponse($request, $e);
    }
}
