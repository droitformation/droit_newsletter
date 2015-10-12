<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Categorie\Repo\CategorieInterface;
use App\Droit\Service\UploadInterface;

class ArretController extends Controller {

    protected $arret;
    protected $categorie;
    protected $upload;
    protected $helper;

    public function __construct( ArretInterface $arret, CategorieInterface $categorie , UploadInterface $upload )
    {

        $this->arret     = $arret;
        $this->categorie = $categorie;
        $this->upload    = $upload;
        $this->helper    = new \App\Droit\Helper\Helper();

    }

	/**
	 * Display a listing of the resource.
	 * GET /arret
	 *
	 * @return Response
	 */

    public function index()
    {
        $arrets     = $this->arret->getAll(195);
        $categories = $this->categorie->getAll(195);
        setlocale(LC_ALL, 'fr_FR');

        return view('admin.arrets.index')->with(array( 'arrets' => $arrets , 'categories' => $categories ));
    }

    /**
     * Return one arret by id
     *
     * @return json
     */
    public function show($id)
    {

        $arret      = $this->arret->find($id);
        $categories = $this->categorie->getAll(195);

        return view('admin.arrets.show')->with(array( 'arret' => $arret, 'categories' => $categories ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categorie->getAll(195);

        return view('admin.arrets.create')->with( array( 'categories' => $categories ) );
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
            $file = $this->upload->upload( $request->file('file') , 'files/arrets' );
        }

        $cats = $request->input('categories');

        if(!empty($cats)){
            $categories = $this->helper->prepareCategories($cats);
        }
        else
        {
            $categories = array();
        }

        // Data array
        $data = array(
            'pid'        => 195,
            'user_id'    => $request->input('user_id'),
            'reference'  => $request->input('reference'),
            'pub_date'   => $request->input('pub_date'),
            'abstract'   => $request->input('abstract'),
            'categories' => count($categories),
            'pub_text'   => $request->input('pub_text'),
            'dumois'     => $request->input('dumois')
        );

        // Attach file if any
        $data['file'] = (!empty($file) ? $file['name'] : '');

        // Create arret
        $arret = $this->arret->create( $data );

        // Insert related categories
        $arret->arrets_categories()->sync($categories);

        return Redirect::to('admin/arret/'.$arret->id)->with( array('status' => 'success' , 'message' => 'Arrêt crée') );

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
            $file = $this->upload->upload( $request->file('file') , 'files/arrets' );
        }

        $cats = $request->input('categories');

        if(!empty($cats)){
            $categories = $this->helper->prepareCategories($cats);
        }
        else{
            $categories = array();
        }

        // Data array
        $data = array(
            'id'         => $request->input('id'),
            'reference'  => $request->input('reference'),
            'pub_date'   => $request->input('pub_date'),
            'abstract'   => $request->input('abstract'),
            'categories' => count($categories),
            'pub_text'   => $request->input('pub_text'),
            'dumois'     => $request->input('dumois')
        );

        // Attach file if any
        $data['file'] = (!empty($file) ? $file['name'] : null);

        // Create arret
        $arret = $this->arret->update( $data );

        // Insert related categories
        $arret->arrets_categories()->sync($categories);

        return redirect('admin/arret/'.$arret->id)->with( array('status' => 'success' , 'message' => 'Arrêt mis à jour') );

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
        $this->arret->delete($id);

        return redirect()->back()->with(array('status' => 'success', 'message' => 'Arrêt supprimée' ));
    }


    /**
     * Return response arrets
     *
     * @return response
     */
    public function arrets()
    {
        return response()->json( $this->arret->getAll() , 200 );
    }


    /**
     * Return one arret by id
     *
     * @return json
     */
    public function simple($id)
    {
        return $this->arret->find($id);
    }

}