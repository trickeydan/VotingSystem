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
}
