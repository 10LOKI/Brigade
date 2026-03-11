<?php
// app/Http/Requests/StorePlatRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'           => 'required|string|max:255',
            'description'   => 'nullable|string',
            'prix'          => 'required|numeric|min:0',
            'image'         => 'nullable|string',
            'disponible'    => 'boolean',
            'stock'         => 'required|integer|min:0',
        ];
    }
}