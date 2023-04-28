<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistrictRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'region_id' => 'required|exists:regions,id',
            'name' => 'required|min:3|max:255|unique:districts,id'
        ];
    }
}
