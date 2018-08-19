<?php
namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

 class ThreadFilters extends Filters
 {
 	protected $filters = ['by', 'some', 'popular'];

 	public function by($username)
 	{
 		$username = $this->request->by;
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
 	}
 	public function popular()
 	{
 		$this->builder->getQuery()->orders = [];
 		return $this->builder->orderBy('replies_count', 'desc');
 	}
 	// public function some($value='')
 	// {
 	// 	# code...
 	// }

 }

