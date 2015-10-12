<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Droit\Categorie\Repo\CategorieInterface;
use App\Droit\Service\UploadInterface;

class CategorieController extends Controller {

    protected $categorie;
    protected $upload;

    public function __construct( CategorieInterface $categorie, UploadInterface $upload )
    {
        $this->categorie = $categorie;
        $this->upload    = $upload;
    }

    /**
     * Show the form for creating a new resource.
     * GET /admin/categorie/create
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->categorie->getAll(195);

        return view('admin.categories.index')->with(array( 'categories' => $categories));
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /categorie/create
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /categorie
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $_file = $request->file('file', null);

        // Files upload
        if( !isset($_file) )
        {
            return redirect()->back()->with( array('status' => 'danger' , 'message' => 'L\'image est requise') );
        }

        $file = $this->upload->upload( $request->file('file') , 'newsletter/pictos' , 'categorie');

        // Data array
        $data['title']      = $request->input('title');
        $data['ismain']     = ($request->input('ismain') ? 1 : 0);
        $data['hideOnSite'] = ($request->input('hideOnSite') ? 1 : 0);
        $data['user_id']    = $request->input('user_id');
        $data['pid']        = 195;
        $data['image']      = (isset($file) && !empty($file) ? $file['name'] : null);

        $categorie = $this->categorie->create( $data );

        return redirect()->to('admin/categorie/'.$categorie->id)->with( array('status' => 'success' , 'message' => 'Catégorie crée') );
	}

	/**
	 * Display the specified resource.
	 * GET /categorie/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $categorie = $this->categorie->find($id);

        return view('admin.categories.show')->with(array( 'categorie' => $categorie));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /categorie/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}

	/**
	 * Update the specified resource in storage.
	 * PUT /categorie/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Request $request)
	{
        $_file = $request->file('file', null);

        // Files upload
        if( $_file )
        {
            $file = $this->upload->upload( $request->file('file') , 'newsletter/pictos' , 'categorie');
        }

        // Data array
        $data['id']         = $id;
        $data['title']      = $request->input('title');
        $data['ismain']     = ($request->input('ismain') ? 1 : 0);
        $data['hideOnSite'] = ($request->input('hideOnSite') ? 1 : 0);
        $data['image']      = (isset($file) && !empty($file) ? $file['name'] : null);

        $this->categorie->update( $data );

        return redirect()->to('admin/categorie/'.$id)->with( array('status' => 'success' , 'message' => 'Catégorie mise à jour') );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /categorie/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->categorie->delete($id);

        return redirect()->back()->with(array('status' => 'success', 'message' => 'Catégorie supprimée' ));
	}

    /**
     * For AJAX
     * Return response categories
     *
     * @return response
     */
    public function categories()
    {
        $categories = $this->categorie->getAll(195);

        return response()->json( $categories, 200 );
    }

    public function arretsExists(){

        $id = $request->input('id');

        $categorie = $this->categorie->find($id);

        $references = (!$categorie->categorie_arrets->isEmpty() ? $categorie->categorie_arrets->lists('reference') : null);

        return response()->json( $references, 200 );
    }

}