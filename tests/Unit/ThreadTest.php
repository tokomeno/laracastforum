<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
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
    public function a_thread_can_make_string_path()
    {

      $thread = factory('App\Thread')->create();
        $this->assertEquals('/threads/'. $thread->channel->slug .'/' . $thread->id, $thread->path() );
    }

    /** @test */
    public function a_thread_has_replies()
    {
    	$thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\User', $thread->creator);

    }


    /** @test */
    public function thread_can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1

        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function thread_belongs_to_chanel()
    {
      $thread = factory('App\Thread')->create();
      factory('App\Channel')->create();

      $this->assertInstanceOf('App\Channel', $thread->channel);
    }


    /** @test */
    public function a_thrad_can_be_sub()
    {

        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();


        $this->assertEquals(1,
          $thread->subscriptions()->where('user_id', auth()->id() )->count()
        );
    }

    /** @test */
    public function a_thread_can_be_unsub()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();

         $this->assertEquals(1,
          $thread->subscriptions()->where('user_id', auth()->id() )->count()
        );

        $thread->unsubscribe();


        $this->assertEquals(0,
          $thread->subscriptions()->where('user_id', auth()->id() )->count()
        );

    }



    /** @test */
    public function if_authed_user_is_subed_to_thread()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);

    }


    /** @test */
    public function a_thread_can_check_if_the_auth_user_has_read_all_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertTrue( $thread->hasUpdatesFor(auth()->user() ) );

        auth()->user()->read($thread);

        $this->assertFalse( $thread->hasUpdatesFor(auth()->user() ) );


    }


}
