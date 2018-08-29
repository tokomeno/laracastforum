<?php

namespace App\Http\Controllers;

// use App\ThreadSubscription;
use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller
{
    public function store($channel, Thread $thread)
    {
       $thread->subscribe();
    }
}
