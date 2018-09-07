<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{


	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(User $user, $notificationId = null)
	{
		if($user->id != auth()->id()){
			abort(404);
		}
		return auth()->user()->unreadNotifications;
	}

    public function destroy(User $user, $notificationId)
    {

    	auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    	// dd($user->notifications);
    }
}
