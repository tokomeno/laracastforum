<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
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
}
