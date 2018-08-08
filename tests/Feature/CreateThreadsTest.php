<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;


class CreateThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

     use DatabaseMigrations;


     /** @test */
    public function auth_user_can_create_thread()
    {
    	 
        // $this->actingAs(factory('App\User')->create());
            //helper funcion creating and sign in user
        $this->signIn();
        // $thread = factory('App\Thread')->make();
        $thread = make('App\Thread'); 
     	$this->post('/threads/', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

      /** @test */
    public function unauth_user_can_not_create_thread()
    {
         
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make(); 
        $this->post('/threads/', $thread->toArray());
 
    }
}
