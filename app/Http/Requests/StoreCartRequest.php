<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'qty' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value !== 'increment' && $value !== 'decrement') {
                        $fail("The {$attribute} field must be a increment or decrement");
                    }
                },
            ],
        ];
    }
}
