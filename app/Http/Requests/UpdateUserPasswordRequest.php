<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'password' => 'required',
            'new_password' => 'required|min:8',
            'password_confirmation' => 'required|same:new_password'
        ];
    }
}
