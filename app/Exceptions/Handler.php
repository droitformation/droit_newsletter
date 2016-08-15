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

        if ($e instanceof \App\Exceptions\CampagneCreationException)
            return redirect()->back()->with(array('status' => 'warning' , 'message' => 'Problème avec la création de campagne sur mailjet'));

        if ($e instanceof \App\Exceptions\ContentCreationException)
            return redirect()->back()->with(array('status' => 'warning' , 'message' => 'Problème avec la création du contenu pour la campagne'));

        if ($e instanceof \App\Exceptions\FileUploadException)
            return redirect()->back()->with(array('status' => 'warning' , 'message' => 'Problème avec l\'upload '.$e->getMessage() ));

        if ($e instanceof \App\Exceptions\SubscribeUserException)
            return redirect('/')->with(array('status' => 'warning' , 'message' => 'Erreur synchronisation email vers mailjet'));

        if ($e instanceof \App\Exceptions\CampagneSendException)
            return redirect('/')->with(array('status' => 'warning' , 'message' => 'Erreur avec l\'envoi de la newsletter, mailjet à renvoyé une erreur'));

        if ($e instanceof \App\Exceptions\DeleteUserException)
            return redirect('/')->with(array('status' => 'warning' , 'message' => 'Erreur avec la suppression de l\'abonnés sur mailjet'));

        if ($e instanceof \App\Exceptions\UserNotExistException)
            return redirect()->back()->with(array('status' => 'warning' , 'message' => 'Cet email n\'existe pas'));

        return parent::render($request, $e);
    }
}
