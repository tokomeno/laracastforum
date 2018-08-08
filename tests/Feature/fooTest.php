<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class fooTest extends TestCase
{
   use DatabaseMigrations;


     /** @test */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
