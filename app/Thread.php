<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;

class Thread extends Model
{   
    use RecordActivity;
    protected $guarded = ['id'];
    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });
 
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
       return $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id() )
            ->exists();

    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }
}
