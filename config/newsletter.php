<?php

return [

    /*
     * Mailjet API credentials
     * */

    'mailjet' => [
        'api'    => env('MAILJET_API'),
        'secret' => env('MAILJET_SECRET'),
    ],

    /*
    * Is used for mutiple sites
    * You need an entitie/model named site with id and slug for folder path
    * */
    'multi' => false,

    /*
     * Is used with Arrets and Categories
     * */
    'components' => [
        1 => 'Image',
        2 => 'Text et image',
        3 => 'Text et image à droite',
        4 => 'Text et image à gauche',
        5 => 'Arrêt',
        6 => 'Text',
        7 => 'Groupe'
    ],

    /*
     * Define Arrets and Categories models
     * */
    'models' => [
        'arret'  => 'App\Droit\Arret\Entities\Arret',
        'groupe' => 'App\Droit\Arret\Entities\Groupe'
    ],

    /*
     * Define categories, arrets and analyses path
     * */

    'path' => [
        'categorie' => 'files/pictos/',
        'arret'     => 'files/arrets/',
        'analyse'   => 'files/analyses/',
        'author'    => 'authors/',
        'upload'    => 'files/',
    ],

    /*
     * Define arrets and analyses links
     * */

    'link' => [
        'arret'   => PHP_SAPI === 'cli' ? false : url('jurisprudence'),
        'analyse' => PHP_SAPI === 'cli' ? false : url('jurisprudence')
    ]

];