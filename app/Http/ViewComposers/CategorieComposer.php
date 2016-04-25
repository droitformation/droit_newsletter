<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Droit\Categorie\Repo\ParentInterface;

class CategorieComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $parent;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(ParentInterface $parent)
    {
        // Dependencies automatically resolved by service container...
        $this->parent = $parent;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $parents = $this->parent->getAll();

        $view->with('parents', $parents);
    }
}