<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,card,other',
            'total' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'رقم الطلب مطلوب.',
            'order_id.exists' => 'الطلب غير موجود.',
            'payment_method.required' => 'طريقة الدفع مطلوبة.',
            'payment_method.in' => 'طريقة الدفع يجب أن تكون واحدة من (cash, card, other).',
            'total.required' => 'المجموع الكلي مطلوب.',
            'total.numeric' => 'المجموع الكلي يجب أن يكون قيمة رقمية.',
            'total.min' => 'المجموع الكلي يجب أن يكون أكبر من أو يساوي 0.',
        ];
    }
}
