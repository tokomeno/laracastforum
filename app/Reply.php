<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordActivity;

	protected $guarded = ['id'];
    protected $with = ['owner', 'favorites'];
    protected $appends = ['isFavorited', 'isBest'];
    protected $touches = ['thread'];

    protected static function boot(){
        parent::boot();

        static::created(function ($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply){
            $reply->thread->decrement('replies_count');

            // if($reply->isBest()){
            //     $reply->thread->update(['best_reply_id' => null]);
            // }
        });
    }

    public function owner(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
    	return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . '#reply-' . $this->id;
    }


    public function wasJustPublished()
    {
        return $this->created_at->gt( Carbon::now()->subMinute() );
    }

    public function mentionedUsers()
    {

        // preg_match_all('/\@([^\s\<\.]+)/', $this->body, $matches);
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);
        return $matches[1];
    }


    public function setBodyAttribute($body)
    {

        $this->attributes['body'] =
        // preg_replace('/@([^\s\.]+)/', "<a href='/profiles/$1'>$0</a>", $body);
        preg_replace('/@([\w\-]+)/', "<a href='/profiles/$1'>$0</a>", $body);

    }


    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }
}
