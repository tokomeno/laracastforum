<?php

namespace Tests\Unit;
use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class SpamTest extends TestCase
{
   use DatabaseMigrations;


     /** @test */
    public function valiate_keywords()
    {
        // $this->assertTrue(true);
        $spam = new Spam();
        $this->assertFalse($spam->detect('Innocent reply here'));


        $this->expectException(\Exception::class);
        $spam->detect('yahoo');
    }

    /** @test */
    public function detect_key_hel_down()
    {
    	$spam = new Spam();

    	$this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException(\Exception::class);
        $spam->detect('aaaaaaaaaaaaaaaa');
    }
}

