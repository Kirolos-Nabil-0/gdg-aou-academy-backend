<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Registration is open to all
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'college_id' => ['required', 'exists:colleges,id'],
            'is_cs' => ['required', 'boolean'],
            'national_id' => ['required', 'string', 'size:14', 'regex:/^[0-9]{14}$/'], // Egyptian national ID format
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'], // International phone format
            'locale' => ['sometimes', 'string', 'in:en,ar'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required',
            'email.unique' => 'This email is already registered',
            'national_id.size' => 'National ID must be exactly 14 digits',
            'national_id.regex' => 'National ID must contain only numbers',
            'phone.regex' => 'Please enter a valid phone number',
        ];
    }
}
