<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'confirmed', 'name', 'email', 'password', 'avatar_path', 'confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    protected $casts = [
        'confirmed' => 'boolean'
    ];


    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * cache user.id.thread.id to check if user
     * has read this thread already
     * @param App\Thread
     * @return void
     **/
    public function read($thread)
    {

        cache()->forever($this->visitedThreadCacheKey($thread), Carbon::now() );
    }


    public function visitedThreadCacheKey($thread)
    {
     return sprintf('users.%s.visits.%s', $this->id, $thread->id);

    }


    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function getAvatarPathAttribute($value)
    {
        return asset('storage/' .$value ?: '/storage/avatars/default.jpg');
    }

    public function avatar()
    {
        return asset('storage/' .$this->avatar_path ?: '/storage/avatars/default.jpg');
    }

}
