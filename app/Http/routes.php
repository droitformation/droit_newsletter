<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['web']], function () {

    Route::get('/', array('as' => 'home', 'uses' => 'Frontend\HomeController@index'));
    Route::get('auteur', 'Frontend\HomeController@auteur');
    Route::get('page/{id}', 'Frontend\HomeController@page');
    Route::get('contact', 'Frontend\HomeController@contact');
    Route::get('jurisprudence', 'Frontend\JurisprudenceController@index');
    Route::get('unsubscribe/{id}', 'Frontend\HomeController@unsubscribe');

    Route::post('sendMessage', 'Frontend\HomeController@sendMessage');
    /*
    |--------------------------------------------------------------------------
    | Subscriptions and newsletter Routes
    |--------------------------------------------------------------------------
    */

    Route::get('newsletter', 'Frontend\NewsletterController@index');
    Route::get('archive', 'Frontend\NewsletterController@archive');
    Route::resource('newsletter', 'Frontend\NewsletterController');
    Route::get('newsletter/campagne/{id}', 'Frontend\NewsletterController@campagne');
    Route::get('campagne/{id}', 'Frontend\CampagneController@show');

    /*
    |--------------------------------------------------------------------------
    | Backend Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'admin', 'middleware' => ['auth','administration']], function () {

        Route::get('/', 'Backend\AdminController@index');
        Route::resource('config', 'Backend\ConfigController');

        Route::post('upload', 'Backend\UploadController@upload');
        Route::post('uploadJS', 'Backend\UploadController@uploadJS');
        Route::post('uploadRedactor', 'Backend\UploadController@uploadRedactor');

        Route::get('imageJson/{id?}', ['uses' => 'Backend\UploadController@imageJson']);
        Route::get('fileJson/{id?}', ['uses' => 'Backend\UploadController@fileJson']);

        Route::resource('arret',     'Backend\ArretController');
        Route::resource('analyse',   'Backend\AnalyseController');
        Route::resource('categorie', 'Backend\CategorieController');
        Route::resource('parent', 'Backend\ParentController');
        Route::resource('contenu',   'Backend\ContentController');
        Route::resource('author',    'Backend\AuthorController');
        Route::resource('page',    'Backend\PageController');
        Route::resource('user', 'Backend\UserController');

        /*
       |--------------------------------------------------------------------------
       | Backend subscriptions, newsletters and campagnes Routes
       |--------------------------------------------------------------------------
       */

        Route::get('ajax/arret/{id}', 'Backend\ArretController@simple'); // build.js
        Route::get('ajax/arrets/{id?}', 'Backend\ArretController@arrets'); // build.js
        Route::get('ajax/categories/{id?}', 'Backend\CategorieController@categories'); // utils.js
        Route::get('ajax/analyses/{id}', 'Backend\AnalyseController@simple');

       /* Route::post('sorting', 'Backend\Newsletter\CampagneController@sorting');
        Route::post('sortingGroup', 'Backend\Newsletter\CampagneController@sortingGroup');

        Route::get('ajax/arrets/{id}',   'Backend\ArretController@simple');
        Route::get('ajax/arrets',        'Backend\ArretController@arrets');
        Route::get('ajax/analyses/{id}', 'Backend\AnalyseController@simple');
        Route::get('ajax/categories',    'Backend\CategorieController@categories');
        Route::post('ajax/categorie/arrets', 'Backend\CategorieController@arrets');

        Route::resource('newsletter', 'Backend\Newsletter\NewsletterController');

        Route::post('clipboard/copy', 'Backend\Newsletter\ClipboardController@copy');
        Route::post('clipboard/paste','Backend\Newsletter\ClipboardController@paste');
        Route::get('clipboard/{id}',  'Backend\Newsletter\ClipboardController@show');

        Route::post('campagne/send', 'Backend\Newsletter\CampagneController@send');
        Route::post('campagne/test', 'Backend\Newsletter\CampagneController@test');
        Route::post('campagne/sorting', 'Backend\Newsletter\CampagneController@sorting');
        Route::post('campagne/process', 'Backend\Newsletter\CampagneController@process');
        Route::post('campagne/editContent', 'Backend\Newsletter\CampagneController@editContent');
        Route::post('campagne/remove', 'Backend\Newsletter\CampagneController@remove');
        Route::get('campagne/create/{newsletter}', 'Backend\Newsletter\CampagneController@create');
        Route::get('campagne/simple/{id}', 'Backend\Newsletter\CampagneController@simple');
        Route::resource('campagne', 'Backend\Newsletter\CampagneController');

        Route::resource('subscriber', 'Backend\Newsletter\SubscriberController');
        Route::get('subscribers', ['uses' => 'Backend\Newsletter\SubscriberController@subscribers']);

        Route::resource('import', 'Backend\Newsletter\ImportController');
        Route::resource('statistics', 'Backend\Newsletter\StatsController');*/
    });

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    */

    Route::get('auth/login',  'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    /*
    |--------------------------------------------------------------------------
    | Registration Routes
    |--------------------------------------------------------------------------
    */

    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');

    /*
    |--------------------------------------------------------------------------
    | Password reset link request Routes
    |--------------------------------------------------------------------------
    */

    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    /*
    |--------------------------------------------------------------------------
    |  Password reset Routes
    |--------------------------------------------------------------------------
    */

    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

});

/*
|--------------------------------------------------------------------------
|  Testing Routes
|--------------------------------------------------------------------------
*/

Route::get('testcampagne', function()
{


    $csv    = public_path('files/import/import.csv');

   // echo file_get_contents($csv);exit;

    $mailjet = \App::make('App\Droit\Newsletter\Worker\MailjetInterface');

    $dataID = $mailjet->uploadCSVContactslistData(file_get_contents($csv));
    return $mailjet->importCSVContactslistData($dataID->ID);

    //$subscription = \App::make('App\Droit\Newsletter\Repo\NewsletterUserInterface');
    //$user = $subscription->findByEmail( 'cindy.leschaud@gmail.com' );
    //$user->subscriptions()->detach(3);


    //$campagne  = \App::make('App\Droit\Newsletter\Worker\CampagneInterface');
    //$campagnes = $campagne->getSentCampagneArrets();

    //$campagnes  = \App::make('App\Droit\Newsletter\Repo\NewsletterContentInterface');
    //$campagne = $campagnes->find(2);

/*    $subscription = \App::make('App\Droit\Newsletter\Repo\NewsletterUserInterface');
    $user = $subscription->findByEmail( 'cindy@leschaud.ch' );

    echo '<pre>';
    print_r($user);

    echo '</pre>';*/

});

Route::get('migration', function()
{
    $migrate = new \App\Droit\Service\MigrateWorker();

    $articles = $migrate->getNewsletter();
    $articles = $articles->slice(3);
    $articles = $migrate->prepare($articles);

  /*  $all = $migrate->getall();

    foreach($all as $campagne){
        $migrate->setCampagne($campagne)->getData();
        $migrate->process();
    }*/

    echo 'End';
    
/*    $slice = array_slice($articles, -3, 1);
    $text =  $slice[0]['content'];

    $date     = $migrate->getNewsletterDate();
    $sujet    = $migrate->getNewsletterSujet();
    $authors  = $migrate->getAuthors();
    //$campagne = $migrate->makeCampagne();

    echo '<pre>';
    print_r($all);
    print_r($articles);
    // echo '<br/>';
    // print_r($arrets);
    //print_r($date);
    echo '</pre>';*/

});


/*
 * Log all queries
 *
Event::listen('illuminate.query', function($query, $bindings, $time, $name)
{
    $data = compact('bindings', 'time', 'name');
    // Format binding data for sql insertion
    foreach ($bindings as $i => $binding)
    {
        if ($binding instanceof \DateTime)
        {
            $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
        }
        else if (is_string($binding))
        {
            $bindings[$i] = "'$binding'";
        }
    }
    // Insert bindings into query
    $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
    $query = vsprintf($query, $bindings);
    Log::info($query, $data);
});
*/