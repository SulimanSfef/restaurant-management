<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'table_id' => 'required|exists:tables,id',
            'reserved_at' => 'required|date',
            'status' => 'required|in:confirmed,pending,cancelled',
            'notes' => 'nullable|string|max:500',
        ];
    }
}

