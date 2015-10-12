<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Service\UploadWorker;

class UploadController extends Controller
{
    protected $upload;

    public function __construct( UploadWorker $upload)
    {
        $this->upload   = $upload;
    }

    public function uploadFile(Request $request)
    {
        $path  = $request->input('path').'/'.$request->input('type');
        $files = $this->upload->upload( $request->file('file') ,$path);

        if($files)
        {
            $this->document->create(
                [
                    'colloque_id' => $request->input('colloque_id'),
                    'type'        => $request->input('type'),
                    'path'        => $files['name'],
                    'titre'       => $request->input('titre')
                ]);

            return redirect()->back()->with(array('status' => 'success', 'message' => 'Document ajouté'));
        }

        return redirect()->back()->with(array('status' => 'danger', 'message' => 'Problème avec le document'));
    }

    public function upload(Request $request)
    {
        $path  = $request->input('path').'/'.$request->input('type');
        $files = $this->upload->upload( $request->file('file') ,$path);

        if($files)
        {
            $array = [
                'success' => true,
                'files'   => $files['name'],
                'get'     => $request->all(),
                'post'    => $request->all()
            ];

            return response()->json($array);
        }

        return false;
    }

    public function uploadJS(Request $request)
    {

        $files = $this->upload->upload( $request->file('file') , 'files' );

        if($files)
        {
            return response()->json([
                'success' => true,
                'files'   => $files,
                'get'     => $request->all(),
                'post'    => $request->all()
            ], 200 );
        }
        return false;
    }

    public function uploadRedactor(Request $request)
    {
        $files = $this->upload->upload( $request->file('file') , 'files' );

        if($files)
        {
            $array = [
                'filelink' => url('/').'/files/'.$files['name'],
                'filename' => $files['name']
            ];

            return response()->json($array,200 );
        }
        return false;
    }

}
