<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class BestReplyController extends Controller
{
    public function store(Reply $reply)
    {

    	// if( $reply->thread->user_id != auth()->id() ) {
    	// 	abort(401);
    	// }

    	$this->authorize('update', $reply->thread);




    	$reply->thread->update(['best_reply_id' => $reply->id]);

    	// $reply->load('thread');
    	// 	dd($reply->toArray());
    }
}
