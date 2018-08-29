<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Activity;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(){
        parent::setUp(); 
    }

    /** @test */
    public function user_can_subscibe_to_thread()
    {   
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path(). '/subscriptions');

        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function know_if_user_is_subscribed()
    { 
        $this->signIn();
        $thread = create('App\Thread');

        $thread->assertTrue($false->isSubscribedTo);
        $thread->subscribe();

        $thread->assertTrue($thread->isSubscribedTo);


    }
}
