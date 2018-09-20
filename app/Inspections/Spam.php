<?php

namespace App\Inspections;

class Spam
{

	protected $inspections = [
		InvalidKeywords::class,
		KeyHelDown::class,
	];

	public function detect($body)
	{
		foreach ($this->inspections as $inspection){
			app($inspection)->detect($body);
		}

		return false;
	}


}
