<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscriptionTest extends TestCase
{
    protected $mock;
    protected $subscription;
    protected $worker;

    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->mock = Mockery::mock('App\Droit\Newsletter\Service\Mailjet');
        $this->app->instance('App\Droit\Newsletter\Service\Mailjet', $this->mock);

        $this->worker = Mockery::mock('App\Droit\Newsletter\Worker\MailjetInterface');
        $this->app->instance('App\Droit\Newsletter\Worker\MailjetInterface', $this->worker);

        $this->subscription = Mockery::mock('App\Droit\Newsletter\Repo\NewsletterUserInterface');
        $this->app->instance('App\Droit\Newsletter\Repo\NewsletterUserInterface', $this->subscription);

        $user = App\Droit\User\Entities\User::find(1);
        $this->be($user);

    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     *
     * @return void
     */
    public function testAddSubscriptionFromAdmin()
    {
        $user = factory(App\Droit\Newsletter\Entities\Newsletter_users::class)->make();
        $user->subscriptions = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make();

        $this->subscription->shouldReceive('create')->once()->andReturn($user);
        $this->worker->shouldReceive('subscribeEmailToList')->once()->andReturn(true);

        $response = $this->call('POST', 'admin/subscriber', ['email' => $user->email, 'newsletter_id' => 3]);

        $this->assertRedirectedTo('admin/subscriber');

    }

    /**
     *
     * @return void
     */
    public function testRemoveAndDeleteSubscription()
    {
        $user = factory(App\Droit\Newsletter\Entities\Newsletter_users::class)->make();
        $user->subscriptions = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make();

        $this->subscription->shouldReceive('findByEmail')->once()->andReturn($user);
        $this->worker->shouldReceive('removeContact')->once()->andReturn(true);
        $this->subscription->shouldReceive('delete')->once();

        $response = $this->action('DELETE','Backend\Newsletter\SubscriberController@destroy', [] ,['email' => 'cindy.leschaud@gmail.com']);

        $this->assertRedirectedTo('admin/subscriber');

    }

}
