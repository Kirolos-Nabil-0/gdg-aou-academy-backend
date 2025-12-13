<?php

namespace App\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class CreateCollegeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('Admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:colleges,name'],
            'name_ar' => ['required', 'string', 'max:255', 'unique:colleges,name_ar'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'College name is required',
            'name.unique' => 'College name already exists',
            'name_ar.required' => 'Arabic college name is required',
            'name_ar.unique' => 'Arabic college name already exists',
        ];
    }
}
