<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;

use App\Droit\Newsletter\Repo\NewsletterUserInterface;
use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Newsletter\Worker\MailjetInterface;

class InscriptionController extends Controller
{
    protected $subscription;
    protected $worker;
    protected $newsletter;

    public function __construct(MailjetInterface $worker, NewsletterUserInterface $subscription, NewsletterInterface $newsletter)
    {
        $this->worker        = $worker;
        $this->subscription  = $subscription;
        $this->newsletter    = $newsletter;
    }

    /**
     * Activate newsletter abo
     * GET //activation
     *
     * @return Response
     */
    public function activation($token)
    {
        // Activate the email on the website
        $user = $this->subscription->activate($token);

        if(!$user)
        {
            return redirect('/')->with(['status' => 'danger', 'jeton' => true ,'message' => 'Le jeton ne correspond pas ou à expiré']);
        }

        $newsletter = $this->newsletter->find(3);

        if(!$newsletter)
        {
            return redirect('/')->with(['status' => 'danger', 'message' => 'Cette newsletter n\'existe pas']);
        }

        //Subscribe to mailjet
        $this->worker->setList($newsletter->list_id);
        $this->worker->subscribeEmailToList( $user->email );

        return redirect('/')->with(['status' => 'success', 'message' => 'Vous êtes maintenant abonné à la newsletter']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(SubscribeRequest $request)
    {
        $email = $this->subscription->findByEmail($request->input('email'));

        if($email)
        {
            $messages = ['status' => 'warning', 'message' => 'Cet email existe déjà'];

            if($email->activated_at == NULL)
            {
                $messages['resend'] = true;
            }

            return redirect('/')->withInput()->with($messages);
        }

        // Subscribe user with activation token to website list and sync newsletter abos
        $suscribe = $this->subscription->create(['email' => $request->input('email'), 'activation_token' => md5($request->input('email').\Carbon\Carbon::now()) ]);

        $suscribe->subscriptions()->attach($request->newsletter_id);

        $html = view('emails.confirmation')->with(['token' => $suscribe->activation_token]);

        $result = $this->worker->sendTest($request->input('email'),$html,'Inscription');

        return redirect('/')
            ->with([
                'status'  => 'success',
                'message' => '<strong>Merci pour votre inscription!</strong><br/>Veuillez confirmer votre adresse email en cliquant le lien qui vous a été envoyé par email'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(SubscribeRequest $request)
    {
        // find the abo
        $abonne = $this->subscription->findByEmail( $request->email );

        // Sync the abos to newsletter we have
        $abonne->subscriptions()->detach($request->newsletter_id);

        if(!$this->worker->removeContact($abonne->email))
        {
            throw new \App\Exceptions\SubscribeUserException('Erreur synchronisation email vers mailjet');
        }

        $this->subscription->delete($abonne->email);

        return redirect('/')->with(array('status' => 'success', 'message' => '<strong>Vous avez été désinscrit</strong>'));
    }

    /**
     * Resend activation link email
     * POST /inscription/resend/email
     *
     * @return Response
     */
   public function resend(Request $request)
    {
        $subscribe = $this->subscription->findByEmail($request->input('email'));

        $html = view('emails.confirmation')->with(['token' => $subscribe->activation_token]);

        $this->worker->sendTest($request->input('email'),$html,'Inscription');

        return redirect('/')->with(['status'  => 'success', 'message' => '<strong>Lien d\'activation envoyé</strong>']);
    }
}
