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

        $reply = factory('App\Reply')->make();
     	$this->post($thread->path() .'/replies', $reply->toArray());

     	// $this->get($thread->path())
     	// 	->assertSee($reply->body);

        $this->assertDatabaseHas('replies', [
            'body' => $reply->body
        ]);

        $this->assertEquals(1, $thread->fresh()->replies_count);
    }


    /** @test */
    public function unauth_user_cannot_delete_rep()
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

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
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
    public function unauth_user_cannot_update_others_reply()
    {
 $this->expectException('Illuminate\Auth\AuthenticationException');
         $reply = factory('App\Reply')->create();

        $this->post("/replies/{$reply->id}", ['body' => 'updated']);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => 'updated']);
    }




    /** @test */
    public function replies_containes_span_may_not_added()
    {
        // $this->expectException(\Exception::class);

        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->json('post', $thread->path(). '/replies', $reply->toArray())
        ->assertStatus(422);

    }


    /** @test */
    public function user_may_not_add_replies_more_than_once()
    {
        $this->signIn();


        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

       $res = $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertStatus(201) ;


        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertStatus(429);

    }
}
