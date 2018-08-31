<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationTest extends TestCase
{
   use DatabaseMigrations;


     /** @test */
    public function notifications_is_prepearde_when_reply_has_been_added()
    {
       $this->signIn();
    	$thread = create('App\Thread')->subscribe();
      	// check thet notifications table is empty

        $thread->addReply([
        	'user_id' => auth()->id(),
        	'body' => 'Some reply here'
        ]);
        // check thet notifications was added after add reply
        $this->assertCount(0, auth()->user()->fresh()->notifications );

        $thread->addReply([
        	'user_id' => create('App\User')->id,
        	'body' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications );
    }


}
