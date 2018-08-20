<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
{
   use DatabaseMigrations;

   /** @test */
   public function guest_cant_fav()
   {
   		$this->expectException('Illuminate\Auth\AuthenticationException');
       $this->post('/replies/1/favorites');
   }

     /** @test */
    public function a_auth_user_can_favorite_any_reply()
    {

    	$this->signIn();
    	$reply = factory('App\Reply')->create();

    	$this->post('replies/'.$reply->id. '/favorites' );
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function auth_user_can_favorite_only_once()
    {
       $this->signIn();
    	$reply = factory('App\Reply')->create();

    	$this->post('replies/'.$reply->id. '/favorites' );
    	$this->post('replies/'.$reply->id. '/favorites' );
        $this->assertCount(1, $reply->favorites);
    }


}
