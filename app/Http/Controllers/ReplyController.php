<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(4);
    }

    public function store($channel, Thread $thread, Request $request)
    {
    	$reply = $thread->addReply([
    		'body' => request('body'),
    		'user_id' => auth()->id()
        ]);
        
        if(request()->ajax()){
            return $reply->load('owner');
         }

    	return redirect()->back();
    }

    public function destroy(Reply $reply)
    {
         $this->authorize('update', $reply);
         $reply->delete();
         if(request()->ajax()){
            return response()->json(['status' => 'reply has been deleted']);
         }
        return redirect()->back();
    }

     public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update( request(['body']) );

        return redirect()->back();
    }
}

