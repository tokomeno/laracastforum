<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    public function auth_user_can_create_thread($value='')
    {
    	// $user = factory('App\User')->create(); 
     //    auth()->login($user);

        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->create(); 
     	$this->post('/threads/'.$thread->id .'/replies', $thread->toArray());
    }
}
