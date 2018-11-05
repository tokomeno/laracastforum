<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;


class LockThreadController extends Controller
{
    public function store(Thread $thread)
    {
        // if(! auth()->user()->isAdmin() ) return response('', 403);
        // $thread->update(['locked' => 1]);
         $thread->lock();
    }

     public function destroy(Thread $thread)
    {
        // if(! auth()->user()->isAdmin() ) return response('', 403);
        $thread->update(['locked' => 0]);
    }

}
