<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Content\Repo\ContentInterface;
use App\Droit\Service\UploadInterface;

class ContentController extends Controller
{
    protected $content;
    protected $upload;

    public function __construct(ContentInterface $content, UploadInterface $upload )
    {
        $this->content   = $content;
        $this->upload    = $upload;

       view()->share('positions', ['sidebar' => 'Barre latérale', 'home-bloc' => 'Accueil bloc plein', 'home-colonne' => 'Accueil bloc colonne']);
    }

    /**
     * Display a listing of the resource.
     * GET /content
     *
     * @return Response
     */
    public function index()
    {
        $content  = $this->content->getAll();

        return view('backend.content.index')->with(['content' => $content]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /content/create
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.content.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /content
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $_file = $request->file('file', null);

        // Files upload
        if(isset($_file) )
        {
            $file = $this->upload->upload( $request->file('file') , 'files');
        }

        // Data array
        $data['titre']    = $request->input('titre');
        $data['contenu']  = $request->input('contenu');
        $data['url']      = $request->input('url');
        $data['slug']     = $request->input('slug');
        $data['type']     = $request->input('type');
        $data['position'] = $request->input('position');
        $data['rang']     = $request->input('rang');
        $data['image']    = (isset($file) && !empty($file) ? $file['name'] : null);

        $content = $this->content->create( $data );

        return redirect('admin/contenu/'.$content->id)->with(['status' => 'success' , 'message' => 'Contenu crée']);
    }

    /**
     * Display the specified resource.
     * GET /content/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $contenu = $this->content->find($id);

        return view('backend.content.show')->with(['contenu' => $contenu]);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /content/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /content/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $_file = $request->file('file', null);

        // Files upload
        if(isset($_file) )
        {
            $file = $this->upload->upload( $request->file('file') , 'files');
        }

        // Data array
        $data['id']       = $id;
        $data['titre']    = $request->input('titre');
        $data['contenu']  = $request->input('contenu');
        $data['url']      = $request->input('url');
        $data['slug']     = $request->input('slug');
        $data['type']     = $request->input('type');
        $data['position'] = $request->input('position');
        $data['rang']     = $request->input('rang');
        $data['image']    = (isset($file) && !empty($file) ? $file['name'] : null);

        $content = $this->content->update( $data );

        return redirect('admin/contenu/'.$content->id)->with(['status' => 'success' , 'message' => 'Contenu mis à jour']);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /content
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->content->delete($id);

        return redirect()->back()->with(['status' => 'success', 'message' => 'Contenu supprimée']);
    }

}
