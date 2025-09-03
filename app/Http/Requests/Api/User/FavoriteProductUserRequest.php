<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteProductUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => 'ID do produto',
        ];
    }
}
