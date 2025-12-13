<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Admin can create users
        return $this->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => ['required', 'in:Admin,HR,Instructor,Learner'],
            'college_id' => ['required', 'exists:colleges,id'],
            'is_cs' => ['boolean'],
            'national_id' => ['required', 'string', 'size:14'],
            'phone' => ['required', 'string', 'regex:/^01[0-2,5]{1}[0-9]{8}$/'],
            'locale' => ['in:en,ar'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
            'role.required' => 'Role is required',
            'role.in' => 'Invalid role. Must be: Admin, HR, Instructor, or Learner',
            'college_id.required' => 'College is required',
            'college_id.exists' => 'Selected college does not exist',
            'national_id.required' => 'National ID is required',
            'national_id.size' => 'National ID must be 14 digits',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Invalid Egyptian phone number format',
        ];
    }
}
