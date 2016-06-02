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

        $actual = $migrate->prepare($collection);

        $this->assertEquals($expect,$actual);

    }

    public function testBlocType()
    {
        $migrate = new \App\Droit\Service\MigrateWorker();

        $article =  [
            'type'    => 'text',
            'content' => ['content' => 'test content']
        ];

        $article1 =  [
            'type'    => 'text',
            'content' => ['title' => 'Test', 'content' => 'test content','image' => 'dwer.png']
        ];

        $article2 =  [
            'type'    => 'arret',
            'content' => ['title' => 'TF title', 'content' => 'test content', 'author' => 'Cindy Leschaud, webmaster']
        ];

        $article3 =  [
            'type'    => 'image',
            'content' => ['image' => 'dwer.png']
        ];

        $this->assertEquals(6, $migrate->blocType($article));
        $this->assertEquals(2, $migrate->blocType($article1));
        $this->assertEquals(5, $migrate->blocType($article2));
        $this->assertEquals(1, $migrate->blocType($article3));

    }

    public function testIsArret()
    {
        $migrate = new \App\Droit\Service\MigrateWorker();

        $this->assertTrue($migrate->isArret('TF 23/qwfv'));
        $this->assertFalse($migrate->isArret('aedrfgthzju'));
    }
}
