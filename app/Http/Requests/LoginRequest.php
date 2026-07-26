<?php

namespace App\Http\Requests;

use Core\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|min:4',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'البريد الإلكتروني مطلوب.',
            'email.email'       => 'يرجى إدخال بريد إلكتروني صحيح وفعال.',
            'password.required' => 'كلمة السر مطلوبة.',
            'password.min'      => 'كلمة السر يجب ألا تقل عن 4 عناصر.',
        ];
    }
}
