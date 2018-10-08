<?php

namespace Tests\Feature;

use App\Trending;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
  public $trending;

   use DatabaseMigrations;

   	protected function setUp(){
   		parent::setUp();
      $this->trending = new Trending();
      $this->trending->reset();
   	}

     /** @test */
    public function it_incremetes_a_threads_score_each_time_it_is_read()
    {
    	$thread = create('App\Thread');

    	$this->assertCount(0, Redis::zrevrange('testing_trending_threads', 0, -1) );
        $this->call('GET', $thread->path());

        $this->assertCount(1, Redis::zrevrange('testing_trending_threads', 0, -1) );

        // dd(Redis::zrevrange('testing_trending_threads', 0, -1));

    }
}
