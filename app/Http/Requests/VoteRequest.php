<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\System;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return System::mode() == System::MODE_VOTE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chosen' => 'required|integer|exists:users,id|not_in:' . Auth::User()->id,
            'category' => 'required|integer|exists:categories,id',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'chosen.required' => 'You must choose a candidate.',
            'chosen.integer'  => 'That candidate is invalid.',
            'chosen.exists'   => 'That candidate couldn\'t be found.',
            'chosen.not_in'   => 'You are not allowed to vote for yourself!',

            'category.required' => 'An error occurred.',
            'category.integer'  => 'An error occurred.',
            'category.exists'   => 'An error occurred.'

        ];
    }
}
