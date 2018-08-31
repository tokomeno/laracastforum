<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubToThreadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
     use DatabaseMigrations;

      public function setUp(){
        parent::setUp();

        // $this->thread = factory('App\Thread')->create();

    }

    /** @test */
    public function a_user_sub_to_threads()
    {
      $this->signIn();
    	$thread = create('App\Thread');
      $this->post($thread->path(). '/subscriptions');

      $this->assertCount(1, $thread->subscriptions);

    }

      /** @test */
      public function a_user_unsub_from_threads()
      {	$this->signIn();

          $thread = create('App\Thread');

          $this->post($thread->path(). '/subscriptions');

          $this->assertCount(1, $thread->fresh()->subscriptions);

          $this->delete($thread->path(). '/subscriptions');

          $this->assertCount(0, $thread->fresh()->subscriptions);

      }
}
