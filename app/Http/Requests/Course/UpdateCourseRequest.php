<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Admin and Instructors can update courses
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
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'track_id' => ['sometimes', 'exists:tracks,id'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'date', 'after:start_date'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'status' => ['sometimes', 'in:draft,published,archived'],
            'visibility' => ['sometimes', 'in:public,hidden'],
            'is_enrollable' => ['sometimes', 'boolean'],
            'waitlist_enabled' => ['sometimes', 'boolean'],
            'instructor_id' => ['sometimes', 'exists:users,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'track_id.exists' => __('messages.validation.course.track_not_exist'),
            'end_date.after' => __('messages.validation.course.end_date_after_start'),
            'instructor_id.exists' => __('messages.validation.course.instructor_not_exist'),
        ];
    }
}
