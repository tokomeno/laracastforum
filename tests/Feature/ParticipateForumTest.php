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
     	$this->post($thread->path() .'/replies', $reply->toArray());

     	$this->get($thread->path())
     		->assertSee($reply->body);

    }


    /** @test */
    public function unauth_usr_cannot_delete_rep()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $reply = factory('App\Reply')->create();
        $this->delete("/replies/{$reply->id}");

        $this->signIn();

    }



    /** @test */
    public function annother_user_cannot_delete_rep()
    {

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $reply = factory('App\Reply')->create();

        $this->signIn();
        $this->delete("/replies/{$reply->id}");
    }

    /** @test */
    public function user_can_delete_his_reply()
    {
        $this->signIn();
        $reply = factory('App\Reply')->create(['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}");
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }


     /** @test */
    public function user_can_update_his_reply()
    {
        $this->signIn();
        $reply = factory('App\Reply')->create(['user_id' => auth()->id()]);

        $this->post("/replies/{$reply->id}", ['body' => 'updated']);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => 'updated']);
    }

      /** @test */
    public function unauth_user_can_update_others_reply()
    {
 $this->expectException('Illuminate\Auth\AuthenticationException');
         $reply = factory('App\Reply')->create();

        $this->post("/replies/{$reply->id}", ['body' => 'updated']);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => 'updated']);
    }
}
