<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

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
}
