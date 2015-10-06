<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MailjetWorkerTest extends TestCase
{
    protected $mock;
    protected $interface;

    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock('App\Droit\Newsletter\Service\Mailjet');
        $this->app->instance('App\Droit\Newsletter\Service\Mailjet', $this->mock);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testSetList()
    {
        $worker = \App::make('App\Droit\Newsletter\Worker\MailjetInterface');

        $worker->setList(1);

        $this->assertEquals(1, 1);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetNewsletters()
    {
        $worker = \App::make('App\Droit\Newsletter\Worker\MailjetInterface');

        $this->mock->shouldReceive('contactslist')->once();

        $worker->getSubscribers();

    }
}
