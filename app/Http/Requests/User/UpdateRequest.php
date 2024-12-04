<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|unique:users,email,' . $this->user_id,
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            //'password' => 'required|min:8',
            'name' => 'required|string',
        ];
    }
}
