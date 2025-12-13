<?php

namespace App\Http\Requests\Session;

use Illuminate\Foundation\Http\FormRequest;

class CreateSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Instructor and Admin can create sessions
        return $this->user()->hasAnyRole(['Admin', 'Instructor']);
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
            'title' => ['required', 'string', 'max:255'],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'modality' => ['required', 'in:online,in-person,hybrid'],
            'location' => ['required', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'course_id.required' => __('messages.validation.session.course_required'),
            'course_id.exists' => __('messages.validation.session.course_not_exist'),
            'title.required' => __('messages.validation.session.title_required'),
            'start_at.required' => __('messages.validation.session.date_required'),
            'start_at.after_or_equal' => __('messages.validation.session.date_future'),
            'end_at.required' => __('messages.validation.session.date_required'),
            'end_at.after' => 'End time must be after start time',
            'modality.required' => 'Session modality is required',
            'modality.in' => 'Modality must be online, in-person, or hybrid',
            'location.required' => 'Location is required',
        ];
    }
}
