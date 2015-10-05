<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Arret\Worker\JurisprudenceWorker;
use App\Droit\Categorie\Repo\CategorieInterface;

class JurisprudenceController extends Controller
{
    protected $arret;
    protected $categorie;
    protected $jurisprudence;

    public function __construct(ArretInterface $arret, CategorieInterface $categorie, JurisprudenceWorker $jurisprudence )
    {
        $this->arret         = $arret;
        $this->categorie     = $categorie;
        $this->jurisprudence = $jurisprudence;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrets     = $this->jurisprudence->preparedArrets();
        $analyses   = $this->jurisprudence->preparedAnalyses();
        $annees     = $this->jurisprudence->preparedAnnees();
        $categories =  $this->categorie ->getAll();

        return view('frontend.jurisprudence')->with(array('arrets' => $arrets, 'analyses' => $analyses, 'annees' => $annees, 'categories' => $categories ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
