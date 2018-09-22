<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Rules\Spamfree;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new \App\Reply);
    }

    protected function failedAuthorization(){
        throw new ThrottleException(
            'You are replies to frequently bro'
        );
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'body' => ['required', new Spamfree]
        ];
    }
}
