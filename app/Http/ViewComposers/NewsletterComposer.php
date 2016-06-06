<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Droit\Newsletter\Repo\NewsletterInterface;

class NewsletterComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $newsletter;

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

        $view->with('newsletters', $newsletters);
    }
}