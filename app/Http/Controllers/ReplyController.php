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

    public function store($channel, Thread $thread, Request $request)
    {

       try {
        $this->validateReply();
    	$reply = $thread->addReply([
    		'body' => request('body'),
    		'user_id' => auth()->id()
        ]);
       } catch( \Exception $e){
          return response('Sorry reply has spam', 422); 
       }




        // if(request()->ajax()){
            return $reply->load('owner');
        //  }

    	// return redirect()->back();
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
        try{
            $this->validateReply(); 
            $reply->update( request(['body']) );

        } catch( \Exception $e){
            return response('Sorry reply has spam', 422); 
        }

        return redirect()->back();
    }


    protected function validateReply(){
        $this->validate(request(), ['body' => 'required']);
        resolve(Spam::class)->detect(request('body'));
    }
}

