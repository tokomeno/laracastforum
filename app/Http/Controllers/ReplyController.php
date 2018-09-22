<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Rules\Spamfree;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;

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
    /**
     *  $this->validate(request(), ['body' => ['required', new Spamfree] ]); instead of this
     *  validate request in CreatePostRequest class
     * @var string
     **/
    public function store($channel, Thread $thread, Request $request, CreatePostRequest $form)
    {

        // if(Gate::denies('create', new Reply)){
        //   return response('To much replies bro :)', 422);
        // }

        return $reply = $thread->addReply([
         'body' => request('body'),
         'user_id' => auth()->id()
        ])->load('owner');

     //   try {
    	// $reply = $thread->addReply([
    	// 	'body' => request('body'),
    	// 	'user_id' => auth()->id()
     //    ]);
     //   } catch( \Exception $e){
     //      return response('Sorry reply has spam', 422);
     //   }
        // return $reply->load('owner');
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
        // try{
        //     $this->validateReply();
        //     $reply->update( request(['body']) );

        // } catch( \Exception $e){
        //     return response('Sorry reply has spam', 422);
        // }

        $this->validate(request(), ['body' => ['required', new Spamfree] ]);
        $reply->update( request(['body']) );

        return redirect()->back();
    }

}

