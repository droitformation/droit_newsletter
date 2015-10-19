<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', array('as' => 'home', 'uses' => 'Frontend\HomeController@index'));
Route::get('auteur', 'Frontend\HomeController@auteur');
Route::get('contact', 'Frontend\HomeController@contact');
Route::get('newsletter', 'Frontend\NewsletterController@index');
Route::get('jurisprudence', 'Frontend\JurisprudenceController@index');
Route::get('unsubscribe/{id}', 'Frontend\HomeController@unsubscribe');

Route::resource('newsletter', 'Frontend\NewsletterController');
Route::get('newsletter/campagne/{id}', 'Frontend\NewsletterController@campagne');

/*
|--------------------------------------------------------------------------
| Subscriptions Routes
|--------------------------------------------------------------------------
*/

Route::post('unsubscribe', 'Backend\Newsletter\InscriptionController@unsubscribe');
Route::post('subscribe', 'Backend\Newsletter\InscriptionController@subscribe');
Route::get('activation/{token}', 'Backend\Newsletter\InscriptionController@activation');
Route::get('campagne/{id}', 'Frontend\CampagneController@show');

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth','administration']], function () {

    Route::get('/', 'Backend\AdminController@index');
    Route::resource('config', 'Backend\ConfigController');
    //Route::get('search', 'Backend\SearchController@search');
    Route::post('upload', 'Backend\UploadController@upload');
    Route::post('uploadJS', 'Backend\UploadController@uploadJS');
    Route::post('uploadRedactor', 'Backend\UploadController@uploadRedactor');

    Route::get('imageJson/{id?}', ['uses' => 'Backend\UploadController@imageJson']);
    Route::get('fileJson/{id?}', ['uses' => 'Backend\UploadController@fileJson']);

    Route::post('sorting', 'Backend\Newsletter\CampagneController@sorting');
    Route::post('sortingGroup', 'Backend\Newsletter\CampagneController@sortingGroup');

    Route::get('ajax/arrets/{id}',   'Backend\ArretController@simple');
    Route::get('ajax/arrets',        'Backend\ArretController@arrets');
    Route::get('ajax/analyses/{id}', 'Backend\AnalyseController@simple');
    Route::get('ajax/categories',    'Backend\CategorieController@categories');
    Route::post('ajax/categorie/arrets', 'Backend\CategorieController@arrets');

    Route::resource('arret',     'Backend\ArretController');
    Route::resource('analyse',   'Backend\AnalyseController');
    Route::resource('categorie', 'Backend\CategorieController');
    Route::resource('contenu',   'Backend\ContentController');
    Route::resource('author',    'Backend\AuthorController');

    /**
     * Campagne & Newsletter
     */
    Route::resource('newsletter', 'Backend\Newsletter\NewsletterController');

    Route::post('campagne/send', 'Backend\Newsletter\CampagneController@send');
    Route::post('campagne/test', 'Backend\Newsletter\CampagneController@test');
    Route::post('campagne/sorting', 'Backend\Newsletter\CampagneController@sorting');
    Route::post('campagne/process', 'Backend\Newsletter\CampagneController@process');
    Route::post('campagne/editContent', 'Backend\Newsletter\CampagneController@editContent');
    Route::post('campagne/remove', 'Backend\Newsletter\CampagneController@remove');
    Route::get('campagne/create/{newsletter}', 'Backend\Newsletter\CampagneController@create');
    Route::get('campagne/simple/{id}', 'Backend\Newsletter\CampagneController@simple');
    Route::resource('campagne', 'Backend\Newsletter\CampagneController');

    Route::resource('statistics', 'Backend\Newsletter\StatsController');

    Route::resource('subscriber', 'Backend\Newsletter\SubscriberController');
    Route::get('subscribers', ['uses' => 'Backend\Newsletter\SubscriberController@subscribers']);
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

/*
|--------------------------------------------------------------------------
|  Testing Routes
|--------------------------------------------------------------------------
*/

Route::get('testcampagne', function()
{
    /*
        $mailjet = \App::make('App\Droit\Newsletter\Worker\MailjetInterface');
        $sent    = $mailjet->getAllLis();

        $subscription = \App::make('App\Droit\Newsletter\Repo\NewsletterUserInterface');
        $user = $subscription->findByEmail( 'cindy.leschaud@gmail.com' );
        $user->subscriptions()->detach(3);
    */

    //$campagne  = \App::make('App\Droit\Newsletter\Worker\CampagneInterface');
    //$campagnes = $campagne->getSentCampagneArrets();

    //$campagnes  = \App::make('App\Droit\Newsletter\Repo\NewsletterContentInterface');
    //$campagne = $campagnes->find(2);

    $subscription = \App::make('App\Droit\Newsletter\Repo\NewsletterUserInterface');
    $user = $subscription->findByEmail( 'cindy@leschaud.ch' );

    echo '<pre>';
    print_r($user);

    echo '</pre>';

});