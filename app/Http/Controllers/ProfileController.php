<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Activity;
 

class ProfileController extends Controller
{
    public function show(User $user)
    {

    	// return view('profiles.show', [
    	// 	'profileUser' => $user,
    	// 	'threads' => $user->threads()->paginate(30)
    	// ]); 
	 	// $activities = $user->activity()->latest()->with('subject')->get()->groupBy(function ($activity) {
		// 	return $activity->created_at->format('Y-m-d');
		// });
    	return view('profiles.show', [
    		'profileUser' => $user,
    		'activities' => Activity::feed($user),
    	]);
    }
}
