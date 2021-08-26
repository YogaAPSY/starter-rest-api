<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    protected function context()
    {
        return array_merge(parent::context(), [
            'foo' => 'bar',
        ]);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable               $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if ($request->wantsJson()) {   //add Accept: application/json in request
        //     return responder()->error(500, 'Terdapat kesalahan pada sistem. Silahkan dicoba lagi.')->respond(500);
        // } else {
        //     $retval = parent::render($request, $exception);
        // }

        if ($exception instanceof ModelNotFoundException) {
            return responder()->error(404, $exception->getMessage())->respond(404);
        } else if ($exception instanceof GithubAPIException) {
            return response()->json(['error' => $exception->getMessage()], 500);
        } else if ($exception instanceof RequestException) {
            return response()->json(['error' => 'External API call failed.'], 500);
        } else {
            return responder()->error(500, 'inbvalud')->respond(500);
        }

        return parent::render($request, $exception);
    }
}
