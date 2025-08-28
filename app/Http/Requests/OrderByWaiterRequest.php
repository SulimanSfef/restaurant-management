<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderByWaiterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // إذا عندك نظام صلاحيات تقدر تعدلها
    }

    public function rules(): array
    {
        return [
            'table_id' => 'required|exists:tables,id',
            'items' => 'required|array|min:1',

            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.note' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'table_id.required' => 'رقم الطاولة مطلوب.',
            'table_id.exists' => 'الطاولة غير موجودة.',
            'items.required' => 'يجب اختيار عنصر واحد على الأقل.',
            'items.*.menu_item_id.required' => 'كل عنصر يجب أن يحتوي على رقم المنتج.',
            'items.*.menu_item_id.exists' => 'المنتج غير موجود في القائمة.',
            'items.*.quantity.required' => 'كمية العنصر مطلوبة.',
            'items.*.quantity.integer' => 'الكمية يجب أن تكون رقم صحيح.',
            'items.*.quantity.min' => 'الكمية يجب أن تكون 1 على الأقل.',
        ];
    }
}
