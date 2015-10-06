<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Newsletter\Repo\NewsletterUserInterface;

class SubscriberController extends Controller
{
    protected $subscriber;
    protected $newsletter;

    public function __construct(NewsletterUserInterface $subscriber, NewsletterInterface $newsletter)
    {
        $this->subscriber = $subscriber;
        $this->newsletter = $newsletter;
    }

    /**
     * Display a listing of the resource.
     * GET /subscriber
     *
     * @return Response
     */
    public function index()
    {
        return view('backend.subscribers.index');
    }

    /**
     * Display a listing of tsubscribers for ajax
     * GET /subscriber/getAllAbos
     *
     * @return Response
     */
    public function subscribers(Request $request)
    {
        $sSearch = $request->input('sSearch');
        $sSearch = ($sSearch && !empty($sSearch) ? $sSearch : null);

        $sEcho          = $request->input('sEcho');
        $iDisplayStart  = $request->input('iDisplayStart');
        $iDisplayLength = $request->input('iDisplayLength');
        $iSortCol_0     = $request->input('iSortCol_0');
        $sSortDir_0     = $request->input('sSortDir_0');

        return $this->subscriber->get_ajax( $sEcho , $iDisplayStart , $iDisplayLength , $iSortCol_0, $sSortDir_0,$sSearch);

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

        return view('backend.subscribers.create')->with(array( 'newsletter' => $newsletter ));
    }

    /**
     * Store a newly created resource in storage.
     * POST /subscriber
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $newsletter_id = ($request->input('newsletter_id') ? $request->input('newsletter_id') : array() );

        $command = array(
            'email'         => $request->input('email'),
            'newsletter_id' => $newsletter_id,
            'activation'    => $request->input('activation')
        );

        //$this->execute('Droit\Command\AdminSubscribeCommand', $command);

        return redirect('admin/subscriber')->with( array('status' => 'success' , 'message' => 'Abonné ajouté') );
    }

    /**
     * Show the form for editing the specified resource.
     * GET /subscriber/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $subscriber     = $this->subscriber->find($id);
        $newsletter = $this->newsletter->getAll();

        return view('backend.subscribers.edit')->with(array( 'subscriber' => $subscriber , 'newsletter' => $newsletter ));
    }

    /**
     * Update the specified resource in storage.
     * PUT /subscriber/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $newsletter_id = ($request->input('newsletter_id') ? $request->input('newsletter_id') : array() );

        $command = array(
            'id'            => $request->input('id') ,
            'email'         => $request->input('email'),
            'newsletter_id' => $newsletter_id,
            'activation'    => $request->input('activation')
        );

        //$this->execute('Droit\Command\UpdateSubscriberCommand', $command );

        return redirect('admin/subscriber/'.$id.'/edit')->with( array('status' => 'success' , 'message' => 'Abonné édité') );

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /subscriber/{id}
     *
     * @param  int  $email
     * @return Response
     */
    public function destroy($email)
    {
        //$this->execute('Droit\Command\UnsubscribeCommand', array('email' => $email, 'newsletter_id' => array(1)));

        return redirect()->back()->with(array('status' => 'success', 'message' => 'Abonné supprimé' ));
    }
}
