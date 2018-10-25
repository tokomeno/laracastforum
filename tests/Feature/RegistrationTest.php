<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Activity;
use App\User;
use App\Mail\ConfirmEmail;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

class RegistrationTest extends TestCase
{
	use DatabaseMigrations;


	/** @test */
	public function a_confirm_email_is_sent_on_registrations()
	{
		Mail::fake();
	    event(new Registered(create('App\User')));
// assertSent
	    Mail::assertQueued(ConfirmEmail::class);

	}

	/** @test */
	public function users_can_confirm_email_adresses()
	{
		Mail::fake();
	    $this->post('/register', [
	    	'name' => 'Toko',
	    	'email' => 'toko@gmail.com',
	    	'password' => 'password',
	    	'password_confirmation' => 'password'
	    ]);

	    $user = User::whereName('Toko')
	    ->first();

	    $this->assertFalse($user->confirmed);
	    $this->assertNotNull($user->confirmation_token);


	    $this->get('/register/confirm?token=' . $user->confirmation_token);

	    $this->assertTrue($user->fresh()->confirmed);
	}
}
