<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
        return parent::report($e);
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
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof \designpond\newsletter\Exceptions\BadFormatException){
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\CampagneCreationException){
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\CampagneSendException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\CampagneUpdateException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\ContentCreationException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\DeleteUserException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\FileUploadException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\ListNotSetException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\MultiSiteException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\SubscribeUserException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\TestSendException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        if ($e instanceof \designpond\newsletter\Exceptions\UserNotExistException)
        {
            alert()->warning($e->getMessage());
            return redirect()->back();
        }

        return parent::render($request, $e);
    }
}
