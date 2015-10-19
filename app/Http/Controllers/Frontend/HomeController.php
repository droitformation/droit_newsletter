<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Author\Repo\AuthorInterface;
use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Content\Repo\ContentInterface;

class HomeController extends Controller
{
    protected $author;
    protected $newsletter;
    protected $helper;
    protected $content;

    public function __construct(AuthorInterface $author, ContentInterface $content, NewsletterInterface $newsletter)
    {
        $this->author     = $author;
        $this->newsletter = $newsletter;
        $this->content    = $content;
        $this->helper     = new \App\Droit\Helper\Helper();

        $newsletters = $this->newsletter->getAll();

        $sidebar = $this->content->findyByPosition(array('sidebar'));
        $sidebar = $sidebar->groupBy('type');

        view()->share('sidebar', $sidebar);
        view()->share('newsletters', $newsletters);
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

}
