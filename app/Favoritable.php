<?php
namespace App;


 trait Favoritable
 {

     protected static function bootFavoritable(){

        static::deleting(function ($model){
            $model->favorites->each->delete();
        });

    }


 	public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function favorite()
    {
        $user = auth()->id();
        if(! $this->favorites()->where('user_id', $user)->exists()){
            return $this->favorites()->create(['user_id' => $user]);
        }

    }


      public function unfavorite()
    {
        $user = auth()->id();
        // return $this->favorites()->where('user_id', $user)->delete();

         return $this->favorites()->where('user_id', $user)->get()->each(function($data){
            $data->delete();
         });


    }

 }



