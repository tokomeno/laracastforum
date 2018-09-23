<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentoined;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyMentoinedUsers
{

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        // preg_match_all('/\@([^\s\/.]+)/', $event->reply->body, $matches);

        $mentionedUsers = $event->reply->mentionedUsers();

        User::whereIn('name', $mentionedUsers)->get()
        ->each(function($user) use ($event){
            $user->notify(new YouWereMentoined($event->reply));
        });

        // foreach ($mentionedUsers as $name) {
        //     $user = User::where('name', $name)->first();

        //     if($user){
        //         $user->notify(new YouWereMentoined($event->reply));
        //     }
        // }
    }
}
