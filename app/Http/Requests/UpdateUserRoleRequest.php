<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => 'required|string|in:admin,waiter,cashier,chef,client',
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'الرجاء إدخال الدور.',
            'role.in' => 'الدور غير صالح. الأدوار المتاحة: admin, waiter, cashier, chef, client.',
        ];
    }
}
