<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', array('as' => 'home', 'uses' => 'Frontend\HomeController@index'));
Route::get('auteur', 'Frontend\HomeController@auteur');
Route::get('contact', 'Frontend\HomeController@contact');
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
    Route::get('search', 'Backend\SearchController@search');
    Route::post('upload', 'Backend\UploadController@upload');
    Route::post('uploadJS', 'Backend\UploadController@uploadJS');
    Route::post('uploadRedactor', 'Backend\UploadController@uploadRedactor');

    Route::resource('newsletter', 'Backend\Newsletter\NewsletterController');
    Route::resource('campagne', 'Backend\Newsletter\CampagneController');

    /**
     * API
     */
    Route::post('campagne/send', 'Backend\Newsletter\CampagneController@send');
    Route::post('campagne/test', 'Backend\Newsletter\CampagneController@test');
    Route::post('campagne/sorting', 'Backend\Newsletter\CampagneController@sorting');
    Route::post('campagne/process', 'Backend\Newsletter\CampagneController@process');
    Route::post('campagne/editContent', 'Backend\Newsletter\CampagneController@editContent');
    Route::post('campagne/remove', 'Backend\Newsletter\CampagneController@remove');

    Route::get('arrets/{id}', 'Backend\ArretController@simple');
    Route::get('analyses/{id}', 'Backend\AnalyseController@simple');
    Route::get('arrets', 'Backend\ArretController@arrets');
    Route::get('categories', 'Backend\CategorieController@categories');

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
/*    $mailjet = \App::make('App\Droit\Newsletter\Worker\MailjetInterface');
    $sent    = $mailjet->getAllSubscribers();
    $subscription = \App::make('App\Droit\Newsletter\Repo\NewsletterUserInterface');
    $user = $subscription->findByEmail( 'cindy.leschaud@gmail.com' );
    $user->subscriptions()->detach(3);*/

    $campagne  = \App::make('App\Droit\Newsletter\Worker\CampagneInterface');
    $campagnes = $campagne->getSentCampagneArrets();

    echo '<pre>';
    print_r($campagnes);
    echo '</pre>';
});