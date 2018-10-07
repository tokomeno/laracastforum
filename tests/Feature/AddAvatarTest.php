<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
   use DatabaseMigrations;


     /** @test */
    public function only_members_can_add_avatarts()
    {
    	$this->expectException('Illuminate\Auth\AuthenticationException');
    	$this->json('post', 'api/users/1/avatar');
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
    	$this->signIn();
        $this->json('post', 'api/users/' . auth()->id() . '/avatar', [
        	'avatar' => 'not image'
        ])
        ->assertStatus(422);
    }


    /** @test */
    public function a_user_may_add_avatar_to_ther_profiel()
    {
    	Storage::fake('public');
        $this->signIn();
        $this->json('post', 'api/users/' . auth()->id() . '/avatar', [
        	'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals(asset('storage/avatars/' . $file->hashName()), auth()->user()->avatar_path );

        Storage::disk('public')->assertExists('avatars/' .
         $file->hashName());
    }

    /** @test */
    public function a_user_can_determine_abatar_path()
    {

        $user = factory('App\User')->create(['avatar_path' => 'avatars/some.jpg']);
        $this->assertEquals($user->avatar_path, asset('storage/avatars/some.jpg') );
    }
}

