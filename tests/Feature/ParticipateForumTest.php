<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateForumTest extends TestCase
{ 

 use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */


    /** @test */
    public function auth_user_can_participate_in_forum()
    {
        // $this->assertTrue(true);
        $user = factory('App\User')->create(); 
        auth()->login($user);
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create(); 
     	$this->post('/threads/'.$thread->id .'/replies', $reply->toArray());

     	$this->get($thread->path())
     		->assertSee($reply->body);
 
    }
}
