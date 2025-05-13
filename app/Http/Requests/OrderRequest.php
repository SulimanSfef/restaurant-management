<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'table_id' => 'required|exists:tables,id',
            'status' => 'required|in:pending,preparing,served,paid,cancelled',
        ];
    }
}


