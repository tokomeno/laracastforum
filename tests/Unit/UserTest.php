<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
   use DatabaseMigrations;


     /** @test */
    public function a_user_can_fetch_last_reply()
    {

      $user = factory('App\User')->create();
      // $reply1 = factory('App\Reply')->create(['user_id' => $user->id]);
      // sleep(1);
      $reply2 = factory('App\Reply')->create(['user_id' => $user->id]);

      $this->assertEquals($user->fresh()->lastReply->id, $reply2->id);
    }
}

