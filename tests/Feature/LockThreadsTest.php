<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class LockThreadsTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function when_thread_is_locked_dont_add_replay()
    {

    	$this->signIn();
        $thread = factory('App\Thread')->create();

        $thread->lock();

        $this->post($thread->path().'/replies', [
        	'body' => 'Foobar',
        	'user_id' => create('App\User')->id
        ])->assertStatus(422);
    }

    /** @test */
    public function non_admin_cant_lock_user()
    {
    	// $this->withExceptionHandling();
   		$this->expectException(\Exception::class);
        $this->signIn();

        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);

    	$this->post(route('lock.thread.store', ['thread' => $thread ]) )->assertStatus(403);

    	$this->assertFalse(!! $thread->fresh()->locked );

    }


       /** @test */
    public function admin_can_lock_thread()
    {
        $this->signIn(
        	$user = factory('App\User')->create(['name' => 'toko'])
    	);

        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);

    	$this->post(route('lock.thread.store', ['thread' => $thread ])  );

    	$this->assertTrue(!! $thread->fresh()->locked );

    }


        /** @test */
    public function admin_can_unlock_thread()
    {
        $this->signIn(
            $user = factory('App\User')->create(['name' => 'toko'])
        );

        $thread = factory('App\Thread')->create(['user_id' => auth()->id()]);

        $this->post(route('lock.thread.store', ['thread' => $thread ])  );

        $this->assertTrue(!! $thread->fresh()->locked );

          $this->delete(route('lock.thread.destroy', ['thread' => $thread ])  );

           $this->assertFalse(!! $thread->fresh()->locked );

    }
}
