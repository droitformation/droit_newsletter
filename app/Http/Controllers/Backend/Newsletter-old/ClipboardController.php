<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Http\Requests\CopyRequest;
use App\Http\Requests\PasteRequest;
use App\Droit\Newsletter\Repo\NewsletterClipboardInterface;
use App\Droit\Newsletter\Repo\NewsletterContentInterface;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;

class ClipboardController extends Controller
{
    protected $clipboard;
    protected $content;
    protected $campagne;

    public function __construct(NewsletterContentInterface $content, NewsletterClipboardInterface $clipboard, NewsletterCampagneInterface $campagne)
    {
        $this->content   = $content;
        $this->campagne  = $campagne;
        $this->clipboard = $clipboard;
    }

    public function show($id)
    {
        $contents   = $this->content->getByCampagne($id);
        $campagne   = $this->campagne->find($id);
        $clipboards = $this->clipboard->getAll();

        return view('backend.newsletter.build.sorting')->with(['contents' => $contents, 'campagne' => $campagne, 'clipboards' => $clipboards, 'isNewsletter' => true]);
    }

    public function copy(CopyRequest $request)
    {
        $this->clipboard->create($request->all());

        return redirect()->back()->with(['status' => 'success', 'message' => 'Contenu copié dans le presse papier']);
    }

    public function paste(PasteRequest $request)
    {
        $copy      = $this->clipboard->find($request->input('id'));
        $content   = $this->content->find($copy->content_id);
        $replicate = $content->replicate();

        $replicate->newsletter_campagne_id = $request->input('campagne_id');
        $replicate->rang = $request->input('rang', 0) + 1;
        $replicate->save();

        $copy->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Contenu collé dans la campagne']);
    }
}
