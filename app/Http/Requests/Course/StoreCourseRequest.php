<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Admin and Instructors can create courses
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'track_id' => ['required', 'exists:tracks,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'status' => ['sometimes', 'in:draft,published,archived'],
            'visibility' => ['sometimes', 'in:public,hidden'],
            'is_enrollable' => ['sometimes', 'boolean'],
            'waitlist_enabled' => ['sometimes', 'boolean'],
            'instructor_id' => ['required', 'exists:users,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => __('messages.validation.course.title_required'),
            'track_id.exists' => __('messages.validation.course.track_not_exist'),
            'start_date.after_or_equal' => __('messages.validation.course.start_date_future'),
            'end_date.after' => __('messages.validation.course.end_date_after_start'),
            'instructor_id.exists' => __('messages.validation.course.instructor_not_exist'),
        ];
    }
}
