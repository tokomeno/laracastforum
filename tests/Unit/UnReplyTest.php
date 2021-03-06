<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnReplyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


    use DatabaseMigrations;

    /** @test */
    public function it_has_an_owner()
    {
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {

        $reply = factory('App\Reply')->create();

        $this->assertTrue( $reply->wasJustPublished() );


        $reply = factory('App\Reply')->create([
            'created_at' => Carbon::now()->subWeek()
        ]);

        $this->assertFalse( $reply->wasJustPublished() );
    }


    /** @test */
    public function it_can_detect_all_mentioned_users()
    {

        $reply = factory('App\Reply')->create(['body' => '@John look at this @Jane you too']);



        $this->assertEquals($reply->mentionedUsers(), ['John', 'Jane']);
    }

    /** @test */
    public function it_wraps_mentioned_user_to_anchor_tag()
    {

        $reply = factory('App\Reply')->create([
            'body' => 'Hello @Toko.'
        ]);

        $this->assertEquals($reply->body, "Hello <a href='/profiles/Toko'>@Toko</a>.");
    }

    /** @test */
    public function it_knows_if_is_best_reply()
    {

        $reply = factory('App\Reply')->create();

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }
}
