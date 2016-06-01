<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MigrateTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testProcessCollection()
    {
        $migrate = new \App\Droit\Service\MigrateWorker();

        $data = [
            ['title'   => '', 'content' => 'test content', 'author'  => ''],
            ['title' => 'TF title', 'content' => 'test content', 'author' => 'Cindy Leschaud, webmaster'],
            ['title' => 'TF title 2', 'content' => 'test content 2', 'author' => 'Cindy Leschaud, webmaster'],
            ['title' => 'TF title 3', 'content' => 'test content 3', 'author' => 'Cindy Leschaud, webmaster'],
            ['image' => 'dwer.png'],
            ['title' => 'TF title', 'content' => 'test content', 'author' => 'Cindy Leschaud, webmaster'],
            ['title' => 'TF title 2', 'content' => 'test content 2', 'author' => 'Cindy Leschaud, webmaster'],
            ['title' => 'TF title 3', 'content' => 'test content 3', 'author' => 'Cindy Leschaud, webmaster'],
        ];

        $collection = new \Illuminate\Support\Collection($data);

        $expect = [
            [
                'type'    => 'text',
                'content' => ['title' => '', 'content' => 'test content', 'author'  => '']
            ],
            [
                'type'    => 'arret',
                'content' => ['title' => 'TF title', 'content' => 'test content', 'author' => 'Cindy Leschaud, webmaster']
            ],
            [
                'type'    => 'arret',
                'content' => ['title' => 'TF title 2', 'content' => 'test content 2', 'author' => 'Cindy Leschaud, webmaster']
            ],
            [
                'type'    => 'arret',
                'content' => ['title' => 'TF title 3', 'content' => 'test content 3', 'author' => 'Cindy Leschaud, webmaster']
            ],
            [
                'type'    => 'image',
                'content' => ['image' => 'dwer.png']
            ],
            [
                'type'    => 'arret',
                'content' => ['title' => 'TF title', 'content' => 'test content', 'author' => 'Cindy Leschaud, webmaster']
            ],
            [
                'type'    => 'arret',
                'content' => ['title' => 'TF title 2', 'content' => 'test content 2', 'author' => 'Cindy Leschaud, webmaster']
            ],
            [
                'type'    => 'arret',
                'content' => ['title' => 'TF title 3', 'content' => 'test content 3', 'author' => 'Cindy Leschaud, webmaster']
            ],
        ];

        $actual = $migrate->process($collection);

        $this->assertEquals($expect,$actual);

    }

    public function testIsArret()
    {
        $migrate = new \App\Droit\Service\MigrateWorker();

        $this->assertTrue($migrate->isArret('TF 23/qwfv'));
        $this->assertFalse($migrate->isArret('aedrfgthzju'));
    }
}
