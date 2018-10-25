<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RegisterConfirmationController extends Controller
{
    public function index(){

   		User::where('confirmation_token', request('token'))
   			->firstOrFail()
   			->update([
   				'confirmed' => true,
   				'confirmation_token' => null,
   			]);

   		return redirect('/threads')
   			->with('flash', 'Your account has been confirme');

    }
}
