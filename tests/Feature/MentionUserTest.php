<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUserTest extends TestCase
{
   use DatabaseMigrations;


     /** @test */
    public function when_user_is_mensitoned_add_notifications()
    {

    	$toko = factory('App\User')->create(['name' => 'toko']);

       	$this->signIn($toko);


       	$thread = factory('App\Thread')->create();

       	$jane = factory('App\User')->create(['name' => 'Jane']);

       	$reply = factory('App\Reply')->create(['body' => '@toko whats up bro, @some']);

       	$this->json('post', $thread->path(). '/replies', $reply->toArray());

       	$this->assertCount(1, $toko->notifications );
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_with_given_character()
    {
      factory('App\User')->create(['name' => 'tokomeno']);
      factory('App\User')->create(['name' => 'johndoe']);
      factory('App\User')->create(['name' => 'johndoe2']);

        $res = $this->json('GET', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $res->json());
    }
}
