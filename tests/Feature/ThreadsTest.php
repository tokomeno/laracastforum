<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseMigrations;


    public function setUp(){
        parent::setUp();

        $this->thread = factory('App\Thread')->create();

    }

    /** @test */
    public function a_user_can_browse_threads()
    {

        $response = $this->get('/threads');

        // $response->assertStatus(200);
        $response->assertSee($this->thread->title);


    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {

        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }
    /** @test */
    public function a_user_can_read_replies_of_thread(){

        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        // $response =
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function filter_thread_by_channel()
    {

        $channel = factory('App\Channel')->create();
        $threadInChannel = factory('App\Thread')
            ->create(['channel_id' => $channel->id]);

        $threadNotInChannel = factory('App\Thread')->create();

        $this->get('/threads/'. $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title)
            ;
    }

    /** @test */
    public function filter_thread_by_usernam()
    {
        $this->signIn(create('App\User', ['name' => 'Doe']));

        $mythread = factory('App\Thread')->create(['user_id' => auth()->user()->id]);

        $thread = factory('App\Thread')->create();

        $this->get('/threads?by=Doe')
            ->assertSee($mythread->title)
            ->assertDontSee($thread->title);

    }

    /** @test */
    public function u_can_filter_by_pop()
    {

        $thread3 = factory('App\Thread')->create();
        factory('App\Reply', 3)
            ->create(['thread_id' => $thread3->id]);

        $thread2 = factory('App\Thread')->create();

        factory('App\Reply', 2)
            ->create(['thread_id' => $thread2->id]);

        $thread = $this->thread;
// dd($this->get('/threads?popular=1'));
        $response = $this->getJson('/threads?popular=1')->json();


        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

}

