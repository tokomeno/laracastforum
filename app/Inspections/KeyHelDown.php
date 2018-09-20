<?php

namespace App\Inspections;

use Exception;

class KeyHelDown
{

	public function detect($body){
		// preg_match('/(.)\\1{4,}/', 'aaaaaaaaaa', $matches);

		if( preg_match('/(.)\\1{6,}/', $body) ){
			throw new \Exception("Error Processing Request");
		}
	}
}
