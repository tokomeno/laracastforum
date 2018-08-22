<?php

namespace App\Http\Controllers;

use App\Channel;

use App\Filters\ThreadFilters;

use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('store', 'create', 'destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channel = null, ThreadFilters $filters)
    {

        if($channel){
        $channelId = Channel::where('slug', $channel)->firstOrFail()->id;
            $threads = Thread::where('channel_id', $channelId)
                ->latest();
        }else{
          $threads = Thread::latest();
        }
        $threads = $threads->filter($filters)->get();


        if(request()->wantsJson()){
            return $threads;
        }

        return view('threads.index', compact('threads'));
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
    public function store(Request $request)
    {
       $this->validate($request, [
           'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
       ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread)
    {
        $replies = $thread->replies()->paginate(10);
        return view('threads.show', compact('thread', 'replies'));
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
    public function update(Request $request, Thread $thread)
    {
        //
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
