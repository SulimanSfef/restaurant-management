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
            'user_id' => 'required|exists:users,id',
            'label'   => 'required|string',
            'area'    => 'required|string',
            'street'  => 'required|string',
            'mobile'  => 'required|string',
            'details' => 'nullable|string',
        ];
    }
}
