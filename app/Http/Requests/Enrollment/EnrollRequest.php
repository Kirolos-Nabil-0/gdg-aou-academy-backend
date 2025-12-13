<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class EnrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Learners can self-enroll, HR/Admin can enroll others
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
            'course_id' => ['required', 'exists:courses,id'],
            'user_id' => ['sometimes', 'exists:users,id'], // For manual enrollment by HR/Admin
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'course_id.required' => __('messages.validation.enrollment.course_required'),
            'course_id.exists' => __('messages.validation.enrollment.course_not_exist'),
            'user_id.exists' => __('messages.validation.enrollment.user_not_exist'),
        ];
    }
}
