<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Activity;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseMigrations;


    public function setUp(){
        parent::setUp();

        // $this->thread = factory('App\Thread')->create();
    }
 
   
    /** @test */
    public function records_activity_when_thread_id_created()
    {   
        $this->signIn();
        $thread = create('App\Thread');

        
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);


        $activity = \App\Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }





     /** @test */
     public function records_activity_when_reply_id_created()
     {
        $this->signIn();
        $reply = create('App\Reply');
 
 
        $this->assertEquals(2, Activity::count()); 

     }
    
    
}