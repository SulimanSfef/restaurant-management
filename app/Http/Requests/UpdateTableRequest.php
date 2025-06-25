<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table_number' => 'sometimes|integer|unique:tables',
            'status' => 'sometimes|in:available,occupied,reserved',
        ];
    }
}
