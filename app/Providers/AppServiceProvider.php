<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extend('emailconfirmed', function ($attribute, $value, $parameters)
        {
            $email = \DB::table('newsletter_users')->where('email','=',$value)->first();

            if($email)
            {
                return (!$email->activated_at ? false  : true);
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthorService();
        $this->registerArretService();
        $this->registerAnalyseService();
        $this->registerCategorieService();
        $this->registerGroupeService();
        $this->registerUploadService();
    }

    /**
     * Author
     */
    protected function registerAuthorService(){

        $this->app->bind('App\Droit\Author\Repo\AuthorInterface', function()
        {
            return new \App\Droit\Author\Repo\AuthorEloquent( new \App\Droit\Author\Entities\Author );
        });
    }


    /**
     * Analyse
     */
    protected function registerAnalyseService(){

        $this->app->bind('App\Droit\Analyse\Repo\AnalyseInterface', function()
        {
            return new \App\Droit\Analyse\Repo\AnalyseEloquent( new \App\Droit\Analyse\Entities\Analyse );
        });
    }

    /**
     * Arret
     */
    protected function registerArretService(){

        $this->app->bind('App\Droit\Arret\Repo\ArretInterface', function()
        {
            return new \App\Droit\Arret\Repo\ArretEloquent( new \App\Droit\Arret\Entities\Arret );
        });
    }

    /**
     * Categorie
     */
    protected function registerCategorieService(){

        $this->app->bind('App\Droit\Categorie\Repo\CategorieInterface', function()
        {
            return new \App\Droit\Categorie\Repo\CategorieEloquent( new \App\Droit\Categorie\Entities\Categorie );
        });
    }


    /**
     * Groupe
     */
    protected function registerGroupeService(){

        $this->app->bind('App\Droit\Arret\Repo\GroupeInterface', function()
        {
            return new \App\Droit\Arret\Repo\GroupeEloquent( new \App\Droit\Arret\Entities\Groupe );
        });
    }

    /**
     * Upload service
     */
    protected function registerUploadService(){

        $this->app->bind('App\Droit\Service\UploadInterface', function()
        {
            return new \App\Droit\Service\UploadWorker();
        });
    }
}
