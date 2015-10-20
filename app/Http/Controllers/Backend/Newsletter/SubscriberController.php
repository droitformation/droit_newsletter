<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Newsletter\Repo\NewsletterUserInterface;
use App\Droit\Newsletter\Worker\MailjetInterface;

use App\Http\Requests\RemoveNewsletterUserRequest;

class SubscriberController extends Controller
{
    protected $subscriber;
    protected $newsletter;
    protected $worker;

    public function __construct(NewsletterUserInterface $subscriber, NewsletterInterface $newsletter, MailjetInterface $worker)
    {
        $this->subscriber = $subscriber;
        $this->newsletter = $newsletter;
        $this->worker     = $worker;
    }

    /**
     * Display a listing of the resource.
     * GET /subscriber
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.newsletter.subscribers.index');
    }

    /**
     * Display a listing of tsubscribers for ajax
     * GET /subscriber/getAllAbos
     *
     * @return Response
     */
    public function subscribers(Request $request)
    {
        return $this->subscriber->get_ajax(
            $request->input('sEcho'),
            $request->input('iDisplayStart'),
            $request->input('iDisplayLength'),
            $request->input('iSortCol_0'),
            $request->input('sSortDir_0'),
            $request->input('sSearch',null)
        );
    }

    /**
     * Show the form for creating a new resource.
     * GET /subscriber/create
     *
     * @return Response
     */
    public function create()
    {
        $newsletter = $this->newsletter->getAll();

        return view('backend.newsletter.subscribers.create')->with(['newsletter' => $newsletter ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /subscriber
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Subscribe user with activation token to website list and sync newsletter abos
        $subscribe = $this->subscriber->create(['email' => $request->input('email'), 'activated_at' => \Carbon\Carbon::now() ]);

        $subscribe->subscriptions()->attach($request->input('newsletter_id'));

        //Subscribe to mailjet
        $lists = $request->input('newsletter_id');

        foreach($lists as $list)
        {
            $this->worker->setList($list);
            $this->worker->subscribeEmailToList($subscribe->email);
        }

        return redirect('admin/subscriber')->with( array('status' => 'success' , 'message' => 'Abonné ajouté') );
    }

    /**
     * Show the form for editing the specified resource.
     * GET /subscriber/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $subscriber = $this->subscriber->find($id);
        $newsletter = $this->newsletter->getAll();

        return view('backend.newsletter.subscribers.show')->with(array( 'subscriber' => $subscriber , 'newsletter' => $newsletter ));
    }

    /**
     * Update the specified resource in storage.
     * PUT /subscriber/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update(RemoveNewsletterUserRequest $request, $id)
    {

        $activated_at = ($request->input('activation') ? date('Y-m-d G:i:s') : null);
        $subscriber   = $this->subscriber->update(['id' => $id, 'email' => $request->input('email'), 'activated_at' => $activated_at]);

        $hadAbos = $subscriber->subscriptions->lists('newsletter_id')->all();
        $abos    = $request->input('newsletter_id', []);

        // Sync the abos to newsletter we have
        $subscriber->subscriptions()->sync($abos);

        $added   = array_diff($abos,$hadAbos);
        $removed = array_diff($hadAbos,$abos);

        if(!empty($added) && $activated_at)
        {
            foreach($added as $list)
            {
                $this->worker->setList($list);
                $this->worker->subscribeEmailToList($subscriber->email);
            }
        }

        if(!empty($removed))
        {
            foreach($added as $list)
            {
                $this->worker->setList($list);
                $this->worker->removeContact($subscriber->email);
            }
        }

        return redirect('admin/subscriber/'.$id)->with( array('status' => 'success' , 'message' => 'Abonné édité') );

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /subscriber/{id}
     *
     * @param  int  $email
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        // Validate the email
        $this->validate($request, array('email' => 'required'));

        // find the abo
        $subscriber = $this->subscriber->findByEmail($request->email );

        // Sync the abos to newsletter we have
        $subscriber->subscriptions()->detach();

        // Delete the abonné from DB
        $this->subscriber->delete($subscriber->email);

        // remove contact from list mailjet
        if(!$this->worker->removeContact($subscriber->email))
        {
            throw new \App\Exceptions\DeleteUserException('Erreur avec la suppression de l\'abonnés sur mailjet');
        }

        return redirect('admin/subscriber')->with(array('status' => 'success', 'message' => 'Abonné supprimé' ));
    }
}
