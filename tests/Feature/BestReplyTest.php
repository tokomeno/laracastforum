<?php

namespace Tests\Feature;

use App\Activity;
use App\Notifications\ThreadWasUpdated;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BestReplyTest extends TestCase
{
    use DatabaseMigrations;


   /** @test */
   public function a_thread_creator_may_mark_reply_as_the_best_reply()
   {
       $this->signIn();

       $thread = factory('App\Thread')->create(['user_id' => auth()->id() ]);

       $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);

       $this->assertFalse($reply->isBest());

       $this->postJson("/replies/{$reply->id}/best");

       $this->assertTrue($reply->fresh()->isBest());
   }


   /** @test */
   public function only_thread_creator_can_set_best_replay()
   {
   		$this->withExceptionHandling();
   		$this->expectException(\Exception::class);

       $this->signIn();
       $thread = factory('App\Thread')->create();


       $reply = factory('App\Reply')->create(['thread_id' => $thread->id], 2);

       $this->signIn();

       $this->postJson("/replies/{$reply->id}/best");

       $this->assertFalse($reply->fresh()->isBest());

   }

   /** @test */
   public function is_best_reply_deleted_($value='')
   {
    \DB::statement("PRAGMA foreign_keys = ON;");
        $this->signIn();

       $reply = factory('App\Reply')->create(['user_id' => auth()->id() ]);

       $reply->thread->update(['best_reply_id' => $reply->id]);
       $thread = $reply->thread;

       $this->assertEquals($reply->id, $reply->thread->best_reply_id);

       $this->delete(route('replies.delete', ['reply' => $reply]));

       $this->assertEquals(null, $thread->fresh()->best_reply_id);

   }
}
