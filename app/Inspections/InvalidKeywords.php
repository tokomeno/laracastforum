<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{

	protected $keywords = [
		'Yahoo'
	];

	public function detect($body){

		foreach ($this->keywords as $keywords){
			if (stripos( $body, $keywords) !== false ){
			    throw new Exception("Error Processing Request");
			}
		}
	}
}
