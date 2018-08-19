<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
{
   use DatabaseMigrations;


     /** @test */
    public function a_auth_user_can_favorite_any_reply()
    {
        ->assertTrue(true);
    }
}
