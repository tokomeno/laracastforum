<?php

namespace Tests\Feature;

use App\Activity;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseMigrations;


    public function setUp(){
        parent::setUp();

        $this->thread = factory('App\Thread')->create(['title' => 'this thread']);

    }


     // if this->thead is created in this method thread is not creating activity feed
    //fuck this is strange thread create doesnot creates activity but from broser does
    /** @test */
    public function authorazied_user_can_delete_thread()
    {
        $this->signIn();
        $thread = factory('App\Thread')
        ->create([ 'user_id' => auth()->id() ]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);


        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('replies', ['id' => $reply->id ]);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id ]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);
    }


    /** @test */
    public function a_user_can_browse_threads()
    {

        $response = $this->get('threads');

        // $response->assertStatus(200);
        $response->assertSee($this->thread->title);


    }

    /** @test */
    public function un_authoraize_user_cant_delete_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');


        $thread = factory('App\Thread')->create();

        $res = $this->delete($thread->path());

        $this->signIn();
        $this->delete($thread->path());
    }


    /** @test */
    public function un_authoraize_diff_user_cant_delete_threads()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $thread = factory('App\Thread')->create();
        $this->signIn();
        $res = $this->delete($thread->path());
        // $res->assertStatus(403);
    }


    /** @test */
    public function a_user_can_read_a_single_thread()
    {

        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }


    // /** @test */
    // public function a_user_can_read_replies_of_thread(){

    //     $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
    //     // $response =
    //     $this->get($this->thread->path())
    //         ->assertSee($reply->body);
    // }

    /** @test */
    public function filter_thread_by_channel()
    {

        $channel = factory('App\Channel')->create();
        $threadInChannel = factory('App\Thread')
            ->create(['channel_id' => $channel->id]);

        $threadNotInChannel = factory('App\Thread')->create();

        $this->get('threads/'. $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title)
            ;
    }

    /** @test */
    public function filter_thread_by_usernam()
    {
        $this->signIn(create('App\User', ['name' => 'Doe']));

        $mythread = factory('App\Thread')->create(['user_id' => auth()->user()->id]);

        $thread = factory('App\Thread')->create();

        $this->get('threads?by=Doe')
            ->assertSee($mythread->title)
            ->assertDontSee($thread->title);

    }





    /** @test */
    public function a_user_can_request_all_replies_of_thread()
    {
        $thread = create('App\Thread');
        $reply = factory('App\Reply', 2)->create(['thread_id' => $thread->id]);


        $response = $this->getJson($thread->path(). '/replies')->json();
// dd($response);
        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }


     /** @test */
    public function u_can_filter_by_pop()
    {

        $thread3 = factory('App\Thread')->create();
        factory('App\Reply', 3)
            ->create(['thread_id' => $thread3->id]);
        $thread2 = factory('App\Thread')->create();
        factory('App\Reply', 2)
            ->create(['thread_id' => $thread2->id]);
        $thread = $this->thread;
        $response = $this->getJson('threads?popular=1')->json();


        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }


    /** @test */
    public function a_user_can_filter_unanswerd_thread()
    {

        $thread = factory('App\Thread')->create();
        factory('App\Reply')->create(['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response);

    }



     /** @test */
    public function a_thrad_notify_subs_when_reply_is_added()
    {

        Notification::fake();

        $this->signIn();
        $this->thread->subscribe()->addReply([
            'body' => 'foobar',
            'user_id' => create('App\User')->id,
        ]);

        $endpoint = '/profile/' .auth()->user()->name. '/notifications/';

        $response = $this->getJson($endpoint)->json();

         Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);


    }

}

