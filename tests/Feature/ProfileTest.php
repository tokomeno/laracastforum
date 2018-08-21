<?php 
namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
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
    public function a_user_has_profile()
    {

        $user = create('App\User');

        $this->get("/profiles/".$user->name)
        	->assertSee($user->name);

    }

        /** @test */
    public function profiles_display_all_threads_by_user()
    {

        $user = create('App\User');
        $thread = create('App\Thread', ['user_id' => $user->id ]);

        $this->get("/profiles/".$user->name)
        		->assertSee($thread->title)
        		->assertSee($thread->body);

    }

}