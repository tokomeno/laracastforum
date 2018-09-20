<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Inspections\Spam;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($channel, Thread $thread, Request $request, Spam $spam)
    {

        $spam->detect($request->body);

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

