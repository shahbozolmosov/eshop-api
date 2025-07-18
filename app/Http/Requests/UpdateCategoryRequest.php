<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255', Rule::unique('categories')->ignore($this->category)],
            'parent_id' => 'nullable|exists:categories,id',
            'image' => [
                File::image()->max(2 * 1024)
            ],
        ];
    }
}
