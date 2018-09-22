<?php

namespace App\Rules;

use App\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class Spamfree implements Rule
{
    public $attribute;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;

        try {
            $res = ! resolve(Spam::class)->detect($value);
            return $res;

        } catch( \Exception $e){
          return false;
        }


    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->attribute .' contains spam';
    }
}
