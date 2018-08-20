<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $guarded = ['id'];
    public function owner(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
    	return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', $user)->exists();
    }

    public function favorite()
    {
    	$user = auth()->user()->id;
    	if(! $this->favorites()->where('user_id', $user)->exists()){
    		return $this->favorites()->create(['user_id' => $user]);
    	}

    }
}
