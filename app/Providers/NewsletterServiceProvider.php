<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Droit\Newsletter\Worker\MailjetInterface', function()
        {
            return new \App\Droit\Newsletter\Worker\MailjetWorker(
                new \App\Droit\Newsletter\Service\Mailjet(
                    config('services.mailjet.api'),config('services.mailjet.secret')
                )
            );
        });
    }

}
