<?php

namespace App;

use App\Activity;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use App\Events\ThreadHasNewReply;

class Thread extends Model
{
    use RecordActivity;
    protected $guarded = ['id'];
    protected $with = ['creator', 'channel'];
    // protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function($builder){
        //     $builder->withCount('replies');
        // });

        static::deleting(function($thread) {
            $thread->replies->each(function ($reply){
                $reply->delete();
            });
        });

        // static::created(function ($thread){
        //    $thread->recordActivity('created', $thread);
        // });

    }



    public function path()
    {
    	return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    public function replies(){
    	return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
    }

    public function creator()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
      // $reply = $this->replies()->create($reply);
      // $this->increment('replies_count');
      // return $reply;
        $reply = $this->replies()->create($reply);

        // $this->subscriptions->filter(function($sub) use ($reply){
        //     return $sub->user_id != $reply->user_id;
        // })->each->notify(new ThreadWasUpdated($this, $reply));

        // foreach ($this->subscriptions as $key => $subscription) {
        //     if( $subscription->user_id != $reply->user_id){
        //         $subscription->user->notify(new ThreadWasUpdated($this, $reply,  $reply->owner->name));
        //         // $subscription->notify(new ThreadWasUpdated($this, $reply, $reply->owner->name));
        //     }
        // }

        // $this->subscriptions->where('user_id', '!=', $reply->user_id)->each(function ($subscription) use ($reply) {
        //     $subscription->user->notify(new ThreadWasUpdated($this, $reply,  $reply->owner->name));
        // });

        // $this->subscriptions
        // ->where('user_id', '!=', $reply->user_id)
        // ->each
        // ->notify($reply);


        // event(new ThreadHasNewReply($this, $reply));
        $this->notifySubs($reply);

        return $reply;
    }


    public function notifySubs($reply){

        $this->subscriptions
        ->where('user_id', '!=', $reply->user_id)
        ->each
        ->notify($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }



    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id() )
            ->exists();
    }

    public function hasUpdatesFor($value='')
    {
        $key = sprintf('users.%s.visits.%s', auth()->id(), $this->id);

        return $this->updated_at > cache($key);
    }
}
