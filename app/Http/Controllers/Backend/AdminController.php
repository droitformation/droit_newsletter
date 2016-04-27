<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Content\Repo\ContentInterface;

class AdminController extends Controller {

	protected $content;
	protected $arret;

    public function __construct(ContentInterface $content, ArretInterface $arret)
    {
		$this->content = $content;
		$this->arret   = $arret;

		view()->share('positions', ['sidebar' => 'Barre latérale', 'home-bloc' => 'Accueil bloc plein', 'home-colonne' => 'Accueil bloc colonne']);

		setlocale(LC_ALL, 'fr_FR.UTF-8');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$arrets   = $this->arret->getAll(5);
		$contents = $this->content->findyByPosition(['home-bloc','home-colonne']);

        return view('backend.index')->with(['arrets' => $arrets, 'contents' => $contents]);
	}

}
