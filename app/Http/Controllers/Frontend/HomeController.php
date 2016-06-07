<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SendMessageRequest;
use App\Http\Controllers\Controller;

use App\Droit\Author\Repo\AuthorInterface;
use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;
use App\Droit\Content\Repo\ContentInterface;
use App\Droit\Page\Repo\PageInterface;

class HomeController extends Controller
{
    protected $author;
    protected $newsletter;
    protected $campagne;
    protected $helper;
    protected $content;
    protected $page;

    public function __construct(AuthorInterface $author, ContentInterface $content,PageInterface $page,  NewsletterInterface $newsletter, NewsletterCampagneInterface $campagne)
    {
        $this->author     = $author;
        $this->newsletter = $newsletter;
        $this->campagne   = $campagne;
        $this->content    = $content;
        $this->page       = $page;
        $this->helper     = new \App\Droit\Helper\Helper();

        $newsletters = $this->newsletter->getAll();

        $sidebar = $this->content->findyByPosition(array('sidebar'));
        $sidebar = $sidebar->groupBy('type');
        $pages   = $this->page->getAll();

        view()->share('pages', $pages);
        view()->share('sidebar', $sidebar);
        view()->share('newsletters', $newsletters);

        setlocale(LC_ALL, 'fr_FR.UTF-8');
    }

    /**
     * Homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homepage = $this->content->findyByPosition(array('home-bloc','home-colonne'));

        return view('frontend.index')->with(['homepage' => $homepage]);
    }

    /**
     * Authors page
     *
     * @return \Illuminate\Http\Response
     */
    public function auteur()
    {
        $auteurs = $this->author->getAll();

        return view('frontend.auteur')->with(['auteurs' => $auteurs]);
    }

    /**
     * Pages
     *
     * @return \Illuminate\Http\Response
     */
    public function page($id)
    {
        $page = $this->page->find($id);

        return view('frontend.page')->with(['page' => $page]);
    }

    /**
     * Contact form
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Unsubcribe page newsletter
     * @return Response
     */
    public function unsubscribe($id)
    {
        $newsletter = $this->newsletter->find($id);

        if(!$newsletter)
        {
            return redirect('/')->with(['status' => 'warning', 'message' => 'Cette newsletter n\'existe pas']);
        }

        return view('frontend.unsubscribe')->with(['id' => $id]);
    }

    /**
     * Send contact message
     *
     * @return Response
     */
    public function sendMessage(SendMessageRequest $request)
    {

        $data = ['email' => $request->input('email'), 'nom' => $request->input('nom'), 'remarque' => $request->input('remarque')];

        \Mail::send('emails.contact', $data , function($message)
        {
            $message->to('info@rcassurances.ch', 'RC Assurances')->subject('Message depuis le site www.rcassurances.ch');
        });

        return redirect()->back()->with(['status' => 'success', 'message' => '<strong>Merci pour votre message</strong><br/>Nous vous contacterons dès que possible.']);

    }

}
