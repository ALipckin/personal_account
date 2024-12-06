<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
    public function rules(): array
    {
        // Проверка, если пользователь не авторизован
        $userId = Auth::check() ? Auth::id() : null;
        return [
            'email' => 'required|string|email|unique:users,email,' . $userId,
            'photo' => 'nullable|file',
            'name' => 'required|string',
        ];
    }
}
