<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;

class ReplyController extends Controller
{
    //

    public function store(Thread $thread, Request $request)
    {
    	$thread->addReply([
    		'body' => request('body'),
    		'user_id' => auth()->id()
    	]);

    	return redirect()->back();
    }
}
