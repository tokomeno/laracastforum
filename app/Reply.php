<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{   
    use Favoritable;

	protected $guarded = ['id'];
    protected $with = ['owner', 'favorites'];

    public function owner(){
    	return $this->belongsTo(User::class, 'user_id');
    }

   


}
