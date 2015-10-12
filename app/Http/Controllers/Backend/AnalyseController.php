<?php

namespace App\Http\Controllers\Backend;

use App\Droit\Analyse\Repo\AnalyseInterface;
use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Categorie\Repo\CategorieInterface;
use App\Droit\Service\UploadInterface;
use App\Droit\Author\Repo\AuthorInterface;
use Illuminate\Http\Request;

class AnalyseController extends \BaseController {

    protected $analyse;
    protected $author;
    protected $arret;
    protected $categorie;
    protected $upload;
    protected $custom;

    public function __construct(AuthorInterface $author, AnalyseInterface $analyse, ArretInterface $arret, CategorieInterface $categorie , UploadInterface $upload )
    {
        $this->beforeFilter('csrf', array('on' => 'post'));

        $this->author    = $author;
        $this->analyse   = $analyse;
        $this->arret     = $arret;
        $this->categorie = $categorie;
        $this->upload    = $upload;
        $this->helper    = new \App\Droit\Helper\Helper();
    }

	/**
	 * Display a listing of the resource.
	 * GET /analyse
	 *
	 * @return Response
	 */

    public function index()
    {
        setlocale(LC_ALL, 'fr_FR');

        $analyses   = $this->analyse->getAll();
        $categories = $this->categorie->getAll(195);

        return view('admin.analyses.index')->with(array( 'analyses' => $analyses , 'categories' => $categories ));
    }

    /**
     * Return one analyse by id
     *
     * @return json
     */
    public function show($id)
    {

        $arrets     = $this->arret->getAll(195);
        $analyse    = $this->analyse->find($id);
        $categories = $this->categorie->getAll(195);
        $auteurs    = $this->author->getAll();

        return view('admin.analyses.show')->with(array( 'analyse' => $analyse, 'arrets' => $arrets, 'categories' => $categories, 'auteurs' => $auteurs ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $arrets     = $this->arret->getAll(195);
        $categories = $this->categorie->getAll(195);
        $auteurs    = $this->author->getAll();

        return view('admin.analyses.create')->with( array( 'arrets' => $arrets, 'categories' => $categories, 'auteurs' => $auteurs ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $_file = $request->file('file');

        // Files upload
        if( $_file && !empty( $_file ) )
        {
            $file = $this->upload->upload( $request->file('file') , 'files/analyses' );
        }

        $cats = $request->input('categories');
        
        if(!empty($cats))
        {
            $categories = $this->helper->prepareCategories($cats);
        }
        else
        {
            $categories = array();
        }

        $arrs = $request->input('arrets');

        if(!empty($arrs))
        {
            $arrets = $this->helper->prepareCategories($arrs);
        }
        else
        {
            $arrets = array();
        }

        // Data array author_id
        $data = array(
            'pid'        => 195,
            'user_id'    => $request->input('user_id'),
            'authors'    => $request->input('authors'),
            'author_id'  => $request->input('author_id'),
            'pub_date'   => $request->input('pub_date'),
            'abstract'   => $request->input('abstract'),
            'arrets'     => count($arrets),
            'categories' => count($categories),
            'pub_text'   => $request->input('pub_text')
        );

        // Attach file if any
        $data['file'] = (!empty($file) ? $file['name'] : '');

        // Create analyse
        $analyse = $this->analyse->create( $data );

        // Insert related categories
        $analyse->analyses_categories()->sync($categories);
        $analyse->analyses_arrets()->sync($arrets);

        return redirect()->to('admin/analyse/'.$analyse->id)->with( array('status' => 'success' , 'message' => 'Analyse crée') );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $_file = $request->file('file');

        // Files upload
        if( $_file && !empty( $_file ) )
        {
            $file = $this->upload->upload( $request->file('file') , 'files/analyses' );
        }

        $cats = $request->input('categories');
        if(!empty($cats)){
            $categories = $this->helper->prepareCategories($cats);
        }
        else{
            $categories = array();
        }

        $arrs = $request->input('arrets');

        if(!empty($arrs)){
            $arrets = $this->helper->prepareCategories($arrs);
        }
        else{
            $arrets = array();
        }

        // Data array
        $data = array(
            'id'         => $request->input('id'),
            'authors'    => $request->input('authors'),
            'author_id'  => $request->input('author_id'),
            'pub_date'   => $request->input('pub_date'),
            'abstract'   => $request->input('abstract'),
            'categories' => count($categories),
            'arrets'     => count($arrets),
            'pub_text'   => $request->input('pub_text')
        );

        // Attach file if any
        $data['file'] = (!empty($file) ? $file['name'] : null);

        // Create analyse
        $analyse = $this->analyse->update( $data );

        // Insert related categories
        $analyse->analyses_categories()->sync($categories);
        $analyse->analyses_arrets()->sync($arrets);

        return redirect()->to('admin/analyse/'.$analyse->id)->with( array('status' => 'success' , 'message' => 'Analyse mise à jour') );

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /adminconotroller/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->analyse->delete($id);

        return redirect()->back()->with(array('status' => 'success', 'message' => 'Analyse supprimée' ));
    }

    /**
     * Return one analyse by id
     *
     * @return json
     */
    public function simple($id)
    {
        return $this->analyse->find($id);
    }
}