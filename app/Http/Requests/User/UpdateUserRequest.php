<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only Admin can update users
        return $this->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'full_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $userId],
            'password' => ['sometimes', 'confirmed', Password::min(8)],
            'college_id' => ['sometimes', 'exists:colleges,id'],
            'is_cs' => ['sometimes', 'boolean'],
            'national_id' => ['sometimes', 'string', 'size:14'],
            'phone' => ['sometimes', 'string', 'regex:/^01[0-2,5]{1}[0-9]{8}$/'],
            'locale' => ['sometimes', 'in:en,ar'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.string' => 'Full name must be a string',
            'email.email' => 'Invalid email format',
            'email.unique' => 'Email already exists',
            'password.confirmed' => 'Password confirmation does not match',
            'college_id.exists' => 'Selected college does not exist',
            'national_id.size' => 'National ID must be 14 digits',
            'phone.regex' => 'Invalid Egyptian phone number format',
        ];
    }
}
