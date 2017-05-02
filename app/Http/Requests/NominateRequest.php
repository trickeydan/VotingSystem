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
}
