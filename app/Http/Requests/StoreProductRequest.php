<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:3|max:255|unique:products',
            'price' => 'required|numeric',
            'description' => 'required|min:20|max:65535',
        ];
    }
}
