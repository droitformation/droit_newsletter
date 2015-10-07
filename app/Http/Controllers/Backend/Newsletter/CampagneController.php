<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;
use App\Droit\Newsletter\Worker\MailjetInterface;

class CampagneController extends Controller
{
    protected $campagne;
    protected $mailjet;

    public function __construct(NewsletterCampagneInterface $campagne,MailjetInterface $mailjet )
    {
        $this->campagne = $campagne;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
