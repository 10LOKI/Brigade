<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'           => 'sometimes|string|max:255',
            'description'   => 'nullable|string',
            'prix'          => 'sometimes|numeric|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'disponible'    => 'boolean',
            'stock'         => 'sometimes|integer|min:0',
        ];
    }
}
