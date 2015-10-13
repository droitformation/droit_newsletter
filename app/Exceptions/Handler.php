<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
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

        if ($e instanceof \App\Exceptions\CampagneCreationException)
            return redirect()->back()->with(array('status' => 'warning' , 'message' => 'Problème avec la création de campagne sur mailjet'));

        if ($e instanceof \App\Exceptions\ContentCreationException)
            return redirect()->back()->with(array('status' => 'warning' , 'message' => 'Problème avec la création du contenu pour la campagne'));

        if ($e instanceof \App\Exceptions\FileUploadException)
            return redirect()->back()->with(array('status' => 'warning' , 'message' => 'Problème avec l\'upload '.$e->getMessage() ));

        if ($e instanceof \App\Exceptions\SubscribeUserException)
            return redirect('/')->with(array('status' => 'warning' , 'message' => 'Erreur synchronisation email vers mailjet'));

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

        return parent::render($request, $e);
    }
}
