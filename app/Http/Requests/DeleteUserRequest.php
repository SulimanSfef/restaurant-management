<?php
// app/Http/Requests/DeleteUserRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ضع شرط صلاحية هنا إذا أردت
    }

    public function rules(): array
    {
        return []; // لا حاجة لقواعد تحقق حالياً
    }
}

