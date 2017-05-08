<?php

namespace App\Http\Requests;

use App\System;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NominateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return System::mode() == System::MODE_NOMINATE;
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
            'chosen.required' => 'You must choose a nominee',
            'chosen.integer'  => 'That nominee is invalid.',
            'chosen.exists'   => 'That nominee couldn\'t be found.',
            'chosen.not_in'   => 'You aren\'t allowed to nominate yourself!',

            'category.required' => 'An error occurred.',
            'category.integer'  => 'An error occurred.',
            'category.exists'   => 'An error occurred.'

        ];
    }
}
