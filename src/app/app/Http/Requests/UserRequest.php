<?php

namespace App\Http\Requests;

use App\Repositories\UserRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:8|confirmed|nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.'
        ];
    }
}
