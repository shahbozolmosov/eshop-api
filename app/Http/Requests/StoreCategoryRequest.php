<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:255|unique:categories',
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }
}
