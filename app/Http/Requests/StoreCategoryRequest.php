<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
            'image' => [
                'required',
                File::image()->max(2 * 1024)
            ],
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }
}
