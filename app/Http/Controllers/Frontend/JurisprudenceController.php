<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Analyse\Repo\AnalyseInterface;
use App\Droit\Categorie\Repo\CategorieInterface;

class JurisprudenceController extends Controller
{
    protected $arret;
    protected $analyse;
    protected $newsworker;
    protected $categorie;

    public function __construct(ArretInterface $arret, AnalyseInterface $analyse, CategorieInterface $categorie)
    {
        $this->arret      = $arret;
        $this->analyse    = $analyse;
        $this->categorie  = $categorie;

        $this->newsworker = \App::make('newsworker');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years      = $this->arret->annees();
        $exclude    = $this->newsworker->arretsToHide([3]);
        $arrets     = $this->arret->getAllActives($exclude);

        $analyses   = $this->analyse->getAll($exclude);
        $categories = $this->categorie->getAll();

        return view('frontend.jurisprudence')->with(['arrets' => $arrets, 'analyses' => $analyses, 'annees' => $years, 'categories' => $categories]);
    }

}
