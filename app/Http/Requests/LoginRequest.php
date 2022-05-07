<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'bail|required|email:rfc',
            'password' => 'bail|required|min:6'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Поле Email обязательно',
            'email.email' => 'Email не соответствующий формат',
            'password.required' => 'Поле пароль обязательно',
            'password.min' => 'Пароль должен быть не менее 6 символов',
        ];
    }
}
