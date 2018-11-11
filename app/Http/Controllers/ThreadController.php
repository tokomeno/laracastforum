<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Rules\Spamfree;
use App\Rules\Recaptcha;
use App\Thread;
use App\Trending;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('store', 'create', 'destroy', 'update');
        $this->middleware('must-be-confirmed')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channel = null, ThreadFilters $filters, Trending $trending)
    {

        if($channel){
            $channelId = Channel::where('slug', $channel)->firstOrFail()->id;
            $threads = Thread::where('channel_id', $channelId)
                ->latest();
        }else{
          $threads = Thread::latest();
        }
        $threads = $threads->filter($filters)->paginate(25);


        if(request()->wantsJson()){
            return $threads;
        }

        $trending = $trending->get();

        // $trending = array_map( 'json_decode', Redis::zrevrange('trending_threads', 0, 5) );

        return view('threads.index', compact('threads', 'trending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Recaptcha $recaptcha)
    {

       $this->validate($request, [
            'title' => ['required', new Spamfree],
            'body' => ['required', new Spamfree],
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => [ $recaptcha ]
       ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
            // 'slug' => str_slug($request->title)

        ]);
         if(request()->wantsJson()){
            return $thread;
        }
        session()->flash('flash', 'thread was published!');
        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread, Trending $trending)
    {
        if(auth()->check()){
           auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->visits()->record();


        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update($channel, Thread $thread, Request $request)
    {

        $this->authorize('update', $thread);

       $request->validate([
            'title' => ['required', new Spamfree],
            'body' => ['required', new Spamfree]
       ]);

        $thread->update($request->only('body', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * we are deltinf replise in thread model
     *
     */
    public function destroy($channel, Thread $thread)
    {
        // if($thread->user_id != auth()->id() ){
        //     return response(['status' =>'Perremission denide'], 403);
        // }

        $this->authorize('update', $thread);
        // $thread->replies()->delete();
        $thread->delete();
        // return response([], 200);
        session()->flash('flash', 'thread was deleted successful!');
        return redirect('threads');
    }


    // protected function getThreads($channel)
    // {
    //     if($channel){
    //     $channelId = Channel::where('slug', $channel)->firstOrFail()->id;
    //         $threads = Thread::where('channel_id', $channelId)
    //             ->latest();
    //     }else{
    //       $threads = Thread::latest();
    //     }
    //     if($username = request('by')){
    //         $user = \App\User::where('name', $username)->firstOrFail();
    //         $threads->where('user_id', $user->id);
    //     }

    //    return $threads->get();
    // }
}
