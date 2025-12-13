<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class MarkAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Instructor, HR, and Admin can mark attendance
        return $this->user()->hasAnyRole(['Admin', 'HR', 'Instructor']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'session_id' => ['required', 'exists:course_sessions,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:present,absent,late,excused'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'session_id.required' => __('messages.validation.attendance.session_required'),
            'session_id.exists' => __('messages.validation.attendance.session_not_exist'),
            'user_id.required' => __('messages.validation.attendance.user_required'),
            'user_id.exists' => __('messages.validation.attendance.user_not_exist'),
            'status.required' => __('messages.validation.attendance.status_required'),
            'status.in' => __('messages.validation.attendance.status_invalid'),
        ];
    }
}
