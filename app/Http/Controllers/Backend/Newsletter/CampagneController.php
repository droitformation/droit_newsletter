<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;
use App\Droit\Newsletter\Repo\NewsletterTypesInterface;
use App\Droit\Newsletter\Worker\CampagneInterface;
use App\Droit\Newsletter\Worker\MailjetInterface;

class CampagneController extends Controller
{
    protected $campagne;
    protected $mailjet;
    protected $types;
    protected $worker;

    public function __construct(NewsletterCampagneInterface $campagne,MailjetInterface $mailjet, NewsletterTypesInterface $types, CampagneInterface $worker )
    {
        $this->campagne = $campagne;
        $this->types    = $types;
        $this->worker   = $worker;
        $this->mailjet  = $mailjet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campagnes = $this->campagne->getAll();

        return view('backend.newsletter.campagne.index')->with(compact('campagnes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.newsletter.campagne.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo '<pre>';
        print_r($request->all());
        echo '</pre>';exit;

        $campagne = $this->campagne->create( ['sujet' => $request->input('sujet'), 'auteurs' => $request->input('auteurs'), 'template' => 1] );

        $created  = $this->mailjet->createCampagne($campagne);

        if(!$created)
        {
            throw new \App\Exceptions\CampagneCreationException('Problème avec la création de campagne sur mailjet');
        }

        return redirect('admin/campagne/'.$campagne->id)->with( array('status' => 'success' , 'message' => 'Campagne crée') );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blocs    = $this->types->getAll();
        $infos    = $this->campagne->find($id);
        $campagne = $this->worker->prepareCampagne($id);

        return view('backend.newsletter.campagne.show')->with(['isNewsletter' => true, 'campagne' => $campagne , 'infos' => $infos, 'blocs' => $blocs]);
    }

    /**
     * Send campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function send()
    {
        //
    }

    /**
     * Send test campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        //
    }

    /**
     * sorting blocs campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function sorting()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
