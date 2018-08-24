<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Activity;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

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


     /** @test */
    public function fetches_afeed_for_any_user()
    {
        $this->signIn();
        create('App\Thread', [
            'user_id' => auth()->id() ,
            'created_at' => Carbon::now()->subWeek()
        ]);
        create('App\Thread', [
            'user_id' => auth()->id()
        ]);
        auth()->user()->activity()->first()->update([
            'created_at' => Carbon::now()->subWeek()
        ]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue( $feed->keys()->contains( Carbon::now()->format('Y-m-d') ) );

        $this->assertTrue( $feed->keys()->contains( Carbon::now()->subWeek()->format('Y-m-d') ) );
    }


}
