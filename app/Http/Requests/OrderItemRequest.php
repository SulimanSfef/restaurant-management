<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'رقم الطلب مطلوب.',
            'order_id.exists' => 'الطلب غير موجود.',
            'menu_item_id.required' => 'رقم العنصر المطلوب مطلوب.',
            'menu_item_id.exists' => 'العنصر المطلوب غير موجود.',
            'quantity.required' => 'الكمية مطلوبة.',
            'quantity.integer' => 'الكمية يجب أن تكون قيمة صحيحة.',
            'quantity.min' => 'الكمية يجب أن تكون أكبر من أو تساوي 1.',
            'note.string' => 'الملاحظة يجب أن تكون نصًا.',
            'note.max' => 'الملاحظة يجب ألا تتجاوز 255 حرفًا.',
        ];
    }
}

