<?php

namespace App\Http\Controllers\Frontend;

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

}
