<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManualReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 public function rules(): array
{
    return [
        'customer_name' => 'required|string',
        'phone' => 'required|string',
        'guest_count' => 'required|integer|min:1',
        'table_number' => 'required|integer',
        'date' => 'required|date',
        'notes' => 'nullable|string|max:1000',
        'booked_slots' => 'required|array|min:1',
        'booked_slots.*' => 'required|string'  // كل عنصر مثل "13:30"
    ];
}

}
