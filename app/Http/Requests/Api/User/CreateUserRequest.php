<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|same:password_confirmation',
            'password_confirmation' => 'required|string|',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome completo',
            'email' => 'E-mail',
            'password' => 'Senha',
            'password_confirmation' => 'Confirmação de senha',
        ];
    }
}
