<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Author\Repo\AuthorInterface;
use App\Droit\Newsletter\Repo\NewsletterInterface;

class HomeController extends Controller
{
    protected $author;
    protected $newsletter;

    public function __construct(AuthorInterface $author, NewsletterInterface $newsletter)
    {
        $this->author     = $author;
        $this->newsletter = $newsletter;

        $newsletters = $this->newsletter->getAll();

        view()->share('newsletters', $newsletters);
    }

    /**
     * Homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.index')->with(array('homepage' => []));
    }

    /**
     * Authors page
     *
     * @return \Illuminate\Http\Response
     */
    public function auteur()
    {
        $auteurs = $this->author->getAll();

        return view('frontend.auteur')->with(array('auteurs' => $auteurs));
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
