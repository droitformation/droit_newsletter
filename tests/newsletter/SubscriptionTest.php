<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

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
    public function testSubscriptionCreationPage()
    {
        $this->visit('admin/subscriber')->click('addSubscriber')->seePageIs('admin/subscriber/create');
    }

    /**
     *
     * @return void
     */
    public function testAddSubscriptionFromAdmin()
    {
        $user = factory(App\Droit\Newsletter\Entities\Newsletter_users::class)->make(['id' => 1]);

        $subscription1 = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 1]);
        $subscription3 = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 2]);

        $user->subscriptions = new \Illuminate\Support\Collection([$subscription1,$subscription3]);

        $this->subscription->shouldReceive('create')->once()->andReturn($user);
        $this->worker->shouldReceive('setList')->once();
        $this->worker->shouldReceive('subscribeEmailToList')->once()->andReturn(true);

        $response = $this->call('POST', 'admin/subscriber', ['email' => $user->email, 'newsletter_id' => [3]]);

        $this->assertRedirectedTo('admin/subscriber');

    }

    /**
     *
     * @return void
     */
    public function testRemoveAndDeleteSubscription()
    {
        $user = factory(App\Droit\Newsletter\Entities\Newsletter_users::class)->make(['id' => 1]);

        $subscription1 = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 1]);
        $subscription3 = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 2]);

        $user->subscriptions = new \Illuminate\Support\Collection([$subscription1,$subscription3]);

        $this->subscription->shouldReceive('findByEmail')->once()->andReturn($user);
        $this->worker->shouldReceive('removeContact')->once()->andReturn(true);
        $this->subscription->shouldReceive('delete')->once();

        $response = $this->action('DELETE','Backend\Newsletter\SubscriberController@destroy', [] ,['email' => 'cindy.leschaud@gmail.com']);

        $this->assertRedirectedTo('admin/subscriber');

    }

    /**
     *
     * @return void
     */
    public function testUpdateSubscriptions()
    {
        $user = factory(App\Droit\Newsletter\Entities\Newsletter_users::class)->make(['id' => 1]);

        $subscription1 = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 1]);
        $subscription3 = factory(App\Droit\Newsletter\Entities\Newsletter_subscriptions::class)->make(['newsletter_id' => 2]);

        $user->subscriptions = new \Illuminate\Support\Collection([$subscription1,$subscription3]);

        $this->subscription->shouldReceive('update')->once()->andReturn($user);

        $this->worker->shouldReceive('setList')->twice();
        $this->worker->shouldReceive('subscribeEmailToList')->once()->andReturn(true);
        $this->worker->shouldReceive('removeContact')->once()->andReturn(true);

        $response = $this->call('PUT', 'admin/subscriber/1', ['id' => 1 , 'email' => 'cindy.leschaud@gmail.com', 'newsletter_id' => [1,3], 'activation' => 1]);

        $this->assertRedirectedTo('admin/subscriber/1');
    }

}
