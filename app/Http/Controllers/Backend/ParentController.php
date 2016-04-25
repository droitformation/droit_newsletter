<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ParentRequest;
use App\Droit\Categorie\Repo\ParentInterface;
use App\Droit\Service\UploadInterface;

class ParentController extends Controller {

    protected $parent;
	protected $upload;

    public function __construct( ParentInterface $parent , UploadInterface $upload)
    {
        $this->parent = $parent;
		$this->upload = $upload;

	}

    /**
     * Show the form for creating a new resource.
     * GET /admin/parent/create
     *
     * @return Response
     */
    public function index()
    {
        $parents = $this->parent->getAll();

        return view('backend.parents.index')->with(['parents' => $parents]);
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /parent/create
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('backend.parents.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /parent
	 *
	 * @return Response
	 */
	public function store(ParentRequest $request)
	{
		$data = $request->except('file');
		$file = $this->upload->upload( $request->file('file') , 'newsletter/pictos' , 'categorie');

		$data['image'] = $file['name'];

		$parent = $this->parent->create( $data );

        return redirect('admin/parent/'.$parent->id)->with(['status' => 'success' , 'message' => 'Catégorie parente crée']);
	}

	/**
	 * Display the specified resource.
	 * GET /parent/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $parent = $this->parent->find($id);

        return view('backend.parents.show')->with(['parent' => $parent]);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /parent/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Request $request)
	{
		$data  = $request->except('file');
		$_file = $request->file('file',null);

		if($_file)
		{
			$file = $this->upload->upload( $_file , 'newsletter/pictos' , 'categorie');
			$data['image'] = $file['name'];
		}

		$this->parent->update( $data );

        return redirect('admin/parent/'.$id)->with(['status' => 'success' , 'message' => 'Catégorie parente mise à jour']);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /parent/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->parent->delete($id);

        return redirect()->back()->with(['status' => 'success', 'message' => 'Catégorie parente supprimée']);
	}

    /**
     * For AJAX
     * Return response parents
     *
     * @return response
     */
    public function parents()
    {
        $parents = $this->parent->getAll();

        return response()->json( $parents, 200 );
    }
}