<?php 
namespace App;


 trait Favoritable
 {
 	public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavorited()
    {   
        $user = auth()->id();
        return $this->favorites->where('user_id', $user)->exists();
    }

    public function favorite()
    {
        $user = auth()->id();
        if(! $this->favorites()->where('user_id', $user)->exists()){
            return $this->favorites()->create(['user_id' => $user]);
        }

    }
 	
 } 



