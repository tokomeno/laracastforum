<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;
use App\Events\ThreadReceivedNewReply;
use App\Activity; 

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

    /**
     * This class event which one has two listeners
     *
     * @var string
     **/
    public function addReply($reply)
    {
        // $this->increment('replies_count');
        $reply = $this->replies()->create($reply);

        // $this->subscriptions->filter(function($sub) use ($reply){
        //     return $sub->user_id != $reply->user_id;
        // })->each->notify(new ThreadWasUpdated($this, $reply));
 
        // $this->subscriptions
        // ->where('user_id', '!=', $reply->user_id)
        // ->each
        // ->notify($reply);
        event(new ThreadReceivedNewReply($reply));
        return $reply;
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

    public function hasUpdatesFor()
    {
        $key = auth()->user()->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }


    //  public function notifySubs($reply){
    //     $this->subscriptions
    //     ->where('user_id', '!=', $reply->user_id)
    //     ->each
    //     ->notify($reply);
    // }
}
