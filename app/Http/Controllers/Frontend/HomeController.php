<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Author\Repo\AuthorInterface;

class HomeController extends Controller
{
    protected $author;

    public function __construct(AuthorInterface $author)
    {
        $this->author = $author;
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
    public function unsubscribe()
    {
        return view('frontend.unsubscribe');
    }

}
