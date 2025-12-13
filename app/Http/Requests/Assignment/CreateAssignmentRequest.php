<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Instructor and Admin can create assignments
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'weight' => ['required', 'integer', 'min:1', 'max:100'],
            'due_at' => ['nullable', 'date', 'after:today'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'Course is required',
            'course_id.exists' => 'Selected course does not exist',
            'name.required' => 'Assignment name is required',
            'weight.required' => 'Assignment weight is required',
            'weight.min' => 'Weight must be at least 1',
            'weight.max' => 'Weight cannot exceed 100',
            'due_at.after' => 'Due date must be in the future',
        ];
    }
}
