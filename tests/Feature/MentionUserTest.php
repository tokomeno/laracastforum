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
}
