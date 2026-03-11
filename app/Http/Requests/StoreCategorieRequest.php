<?php
// app/Http/Requests/StoreCategorieRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}