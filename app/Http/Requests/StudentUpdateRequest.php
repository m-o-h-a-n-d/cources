<?php

namespace App\Http\Requests;

use Core\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return isset($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
    }

    public function rules(): array
    {
        return [
            'record_id'    => 'required|numeric',
            'student_id'   => 'required|numeric',
            'full_name'    => 'required|string|min:3',
            'email'        => 'required|email',
            'age'          => 'required|numeric',
            'gender'       => 'required|in:Male,Female',
            'phone'        => 'required|egyptian_phone',
            'parent_phone' => 'required|egyptian_phone',
            'address'      => 'required|string',
            'dep_id'       => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'record_id.required'   => 'معرف السجل مطلوب.',
            'student_id.required'  => 'كود الطالب مطلوب.',
            'full_name.required'   => 'اسم الطالب بالكامل مطلوب.',
            'email.email'          => 'البريد الإلكتروني غير صحيح أو غير فعال.',
            'phone.egyptian_phone' => 'رقم الهاتف يجب أن يكون رقم محمول مصري صحيح.',
            'parent_phone.egyptian_phone' => 'رقم هاتف ولي الأمر يجب أن يكون رقم محمول مصري صحيح.',
        ];
    }
}
