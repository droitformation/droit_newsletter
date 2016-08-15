<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use designpond\newsletter\Newsletter\Repo\NewsletterInterface;

class NewsletterComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $newsletter;
    protected $newsworker;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(NewsletterInterface $newsletter)
    {
        // Dependencies automatically resolved by service container...
        $this->newsletter = $newsletter;
        $this->newsworker = \App::make('newsworker');
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $newsletters = $this->newsletter->find(3);
        $year_news   = $this->newsworker->getArchives(3,date('Y'));

        $view->with('newsletters', $newsletters);
        $view->with('year_news', $year_news);
    }
}