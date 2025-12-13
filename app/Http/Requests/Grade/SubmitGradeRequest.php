<?php

namespace App\Http\Requests\Grade;

use Illuminate\Foundation\Http\FormRequest;

class SubmitGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Instructor and Admin can submit grades
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
            'assignment_id' => ['required', 'exists:assignments,id'],
            'user_id' => ['required', 'exists:users,id'],
            'score' => ['required', 'numeric', 'min:0', 'max:100'],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'assignment_id.required' => __('messages.validation.grade.assignment_required'),
            'assignment_id.exists' => __('messages.validation.grade.assignment_not_exist'),
            'user_id.required' => __('messages.validation.grade.user_required'),
            'user_id.exists' => __('messages.validation.grade.user_not_exist'),
            'score.required' => __('messages.validation.grade.score_required'),
            'score.numeric' => __('messages.validation.grade.score_numeric'),
            'score.max' => 'Score cannot exceed 100',
        ];
    }
}
