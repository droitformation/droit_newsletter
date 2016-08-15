<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Newsletter\Repo\NewsletterInterface;

class NewsletterController extends Controller
{
    protected $newsletter;
    protected $newsworker;

    public function __construct(NewsletterInterface $newsletter)
    {
        $this->newsletter = $newsletter;
        $this->newsworker = \App::make('newsworker');

        setlocale(LC_ALL, 'fr_FR.UTF-8');
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

        return view('frontend.newsletter.newsletter')->with(['newsletter' => $newsletter]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
        return view('frontend.newsletter.archives');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function campagne($id)
    {
        $campagne = $this->newsworker->getCampagne($id);

        return view('frontend.newsletter.campagne')->with(['campagne' => $campagne]);
    }
}
