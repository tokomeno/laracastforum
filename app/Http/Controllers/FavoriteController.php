<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{


	public function __construct()
	{
		$this->middleware('auth');
	}


    public function store(Reply $reply, Request $request)
    {
    	// $fav = Favorite::create([
    	// 	'user_id' => auth()->user()->id,
    	// 	'favorited_id' => $reply->id,
    	// 	'favorited_type' => get_class($reply)
    	// ]);

    	$reply->favorite();
        return redirect()->back();
    }


     public function destroy(Reply $reply, Request $request)
    {
        // $fav = Favorite::create([
        //  'user_id' => auth()->user()->id,
        //  'favorited_id' => $reply->id,
        //  'favorited_type' => get_class($reply)
        // ]);

        $reply->unfavorite();
    }
}
