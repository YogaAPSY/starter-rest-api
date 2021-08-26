<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return responder()->error(404, 'not gfudbud')->respond(404);
    }
}
