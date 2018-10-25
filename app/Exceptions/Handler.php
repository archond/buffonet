<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
	    AuthorizationException::class,
	    HttpException::class,
	    ModelNotFoundException::class,
	    ValidationException::class,
	    Illuminate\Session\TokenMismatchException::class,
	    TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldReport($e)) {
            
            $person = Auth::check() ? Auth::user()->toArray() : null;

            \Log::error($e, [
                'person' => $person
            ]);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if (config('app.debug'))
        {
            $whoops = new \Whoops\Run;

            if ($request->ajax()) {
                $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
            } else{
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            }

            $whoops->handleException($e);
            exit;
//            return response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
        } else {
            return parent::render($request, $e);
        }

        

        // return response()->view('errors.all-errors', ['e' => $e], $e->getStatusCode());
    }

}
