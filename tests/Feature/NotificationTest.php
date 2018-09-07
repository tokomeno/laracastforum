<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationTest extends TestCase
{
   use DatabaseMigrations;

    public function setUp(){
      parent::setUp();
      $this->signIn();
    }

     /** @test */
    public function notifications_is_prepearde_when_reply_has_been_added()
    {

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

     /** @test */
    public function a_user_can_mark_notification_as_read()
    {

      $thread = create('App\Thread')->subscribe();
      $thread->addReply([
        'user_id' => create('App\User')->id,
        'body' => 'Some reply here'
      ]);


      $notId = auth()->user()->unreadNotifications->first()->id;
      $this->assertCount(1, auth()->user()->unreadNotifications );
      $endpoint = '/profile/' .auth()->user()->name. '/notifications/' . $notId;

      $this->delete($endpoint);
      $this->assertCount(0, auth()->user()->fresh()->unreadNotifications );

    }

    /** @test */
    public function a_user_can_fetch_unread_not()
    {

        $thread = create('App\Thread')->subscribe();
        $thread->addReply([
          'user_id' => create('App\User')->id,
          'body' => 'Some reply here'
        ]);
        $notId = auth()->user()->unreadNotifications->first()->id;

        $endpoint = '/profile/' .auth()->user()->name. '/notifications/';

       $response = $this->getJson($endpoint)->json();

        $this->assertCount(1, $response);


    }


}
