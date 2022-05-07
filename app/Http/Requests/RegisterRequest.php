<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'bail|required|email:rfc|unique:users,email',
            'name' => 'bail|required|string|min:2',
            'password' => 'bail|required|min:6|confirmed'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Поле Email обязательно!',
            'email.unique' => 'Email существует!',
            'name.required' => 'Поле Имя обязательно!',
            'name.min' => 'Пароль должен быть не менее 2 символов!',
            'password.required' => 'Поле пароль обязательно!',
            'password.min' => 'Пароль должен быть не менее 6 символов!',
            'password.confirmed' => 'Пароли не совпадают!',
        ];
    }
}
