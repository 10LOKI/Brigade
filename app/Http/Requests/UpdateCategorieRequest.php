<?php
// app/Http/Requests/UpdateCategorieRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategorieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'         => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}