<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
            'images' => 'required',
            'images.*' => [
                'required',
                File::image()->max(2 * 1024)
            ],
            'qty_left' => 'required|numeric'
        ];
    }
}
