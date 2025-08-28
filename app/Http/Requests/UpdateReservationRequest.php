<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest  extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20',
            'table_id' => 'sometimes|exists:tables,id',
            'duration_minutes' => 'sometimes|integer|min:1',
            'reserved_at' => 'sometimes|date_format:Y-m-d H:i:s|after:now',
            'notes' => 'nullable|string|max:500',
        ];
    }
}

