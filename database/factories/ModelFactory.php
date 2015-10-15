<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Droit\User\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter_users::class, function (Faker\Generator $faker) {
    return [
        'email'        => $faker->email,
        'token'        => '1234',
        'activated_at' => date('Y-m-d G:i:s')
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class, function (Faker\Generator $faker) {
    return [
        'user_id'       => 1,
        'newsletter_id' => 1
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter::class, function (Faker\Generator $faker) {
    return [
        'id'           => 1,
        'titre'        => 'Titre',
        'list_id'      => '1',
        'from_name'    => 'Nom',
        'from_email'   => 'cindy.leschaud@gmail.com',
        'return_email' => 'cindy.leschaud@gmail.com',
        'unsuscribe'   => 'unsubscribe',
        'preview'      => 'droit.local',
        'logos'        => 'logos.jpg',
        'header'       => 'header.jpg',
        'color'        => '#fff'
    ];
});

$factory->define(App\Droit\Newsletter\Entities\Newsletter_campagnes::class, function (Faker\Generator $faker) {
    return [
        'sujet'         => 'Sujet',
        'auteurs'       => 'Cindy Leschaud',
        'status'        => 'Brouillon',
        'newsletter_id' => 1
    ];
});