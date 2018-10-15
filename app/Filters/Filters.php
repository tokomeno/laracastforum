<?php
namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
 {
	protected $request, $builder;

	protected $filters = [];


 	public function __construct(Request $request)
 	{
		$this->request = $request;
 	}


 	public function apply($builder)
 	{
 		$this->builder = $builder;


 		/**
 		 * foreach in array filters and if exists this value means there is method and returns this method
 		 *
 		 * @return method
 		 **/
 		// dd($this->request->only($this->filters) );
 		foreach ($this->request->only($this->filters) as $key => $filter) {
 			if($this->hasFilter($key)){
 				$this->$key($this->request->filter);
 			}
 		}
        return $builder;

 	}

 	public function hasFilter($filter)
 	{
 		return method_exists($this, $filter) && $this->request->has($filter);
 	}


 	// public function apply($builder)
 	// {
 	// 	$this->builder = $builder;



  //       if($this->request->has('by')){
  //       	return $this->by($this->request->by);
  //       }
  //       return $builder;

 	// }

}
