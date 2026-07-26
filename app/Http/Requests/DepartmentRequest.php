<?php

namespace App\Http\Requests;

use Core\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم القسم مطلوب.',
            'name.min'      => 'اسم القسم يجب أن يتكون من حرفين على الأقل.',
        ];
    }
}
