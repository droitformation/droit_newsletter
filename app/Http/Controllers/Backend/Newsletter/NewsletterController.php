<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Service\UploadWorker;
use App\Droit\Newsletter\Worker\MailjetInterface;

class NewsletterController extends Controller
{
    protected $newsletter;
    protected $upload;
    protected $mailjet;

    public function __construct(NewsletterInterface $newsletter, UploadWorker $upload, MailjetInterface $mailjet )
    {
        $this->newsletter = $newsletter;
        $this->upload     = $upload;
        $this->mailjet    = $mailjet;

        $lists = $this->mailjet->getAllLists();

        if(isset($lists->Data))
        {
            view()->share('lists', $lists->Data);
        }

        setlocale(LC_ALL, 'fr_FR.UTF-8');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletters = $this->newsletter->getAll();

        return view('backend.newsletter.template.index')->with(compact('newsletters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.newsletter.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newsletter = $this->newsletter->create($request->except('logos','header'));

        $logos  = $this->upload->upload($request->file('logos'), 'newsletter');
        $header = $this->upload->upload($request->file('header'), 'newsletter');

        $newsletter->logos  = $logos['name'];
        $newsletter->header = $header['name'];
        $newsletter->save();

        return redirect('admin/newsletter/'.$newsletter->id)->with(array('status' => 'success', 'message' => 'Newsletter crée' ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newsletter = $this->newsletter->find($id);

        return view('backend.newsletter.template.show')->with(compact('newsletter'));
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

        $newsletter = $this->newsletter->update($request->except('logos','header'));

        $logos  = $request->file('logos',null);
        $header = $request->file('header',null);

        if($logos)
        {
            $logos  = $this->upload->upload($request->file('logos'), 'newsletter');

            $newsletter->logos  = $logos['name'];
            $newsletter->save();
        }

        if($header)
        {
            $header = $this->upload->upload($request->file('header'), 'newsletter');

            $newsletter->header = $header['name'];
            $newsletter->save();
        }

        return redirect('admin/newsletter/'.$newsletter->id)->with(array('status' => 'success', 'message' => 'Newsletter édité' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->newsletter->delete($id);

        return redirect()->back()->with(array('status' => 'success', 'message' => 'Newsletter supprimée' ));
    }
}
