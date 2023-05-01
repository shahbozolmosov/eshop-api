<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'region_id' => 'required|exists:regions,id',
            'district_id' => 'required|exists:districts,id',
            'street' => 'required|min:3|max:255',
            'house' => 'required|min:3|max:255',
            'apartment' => 'required|max:255',
            'floor' => 'required|max:255',
        ];
    }
}
