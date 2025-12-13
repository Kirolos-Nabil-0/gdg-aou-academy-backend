<?php

namespace App\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollegeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('Admin');
    }

    public function rules(): array
    {
        $collegeId = $this->route('id');

        return [
            'name' => ['sometimes', 'string', 'max:255', 'unique:colleges,name,' . $collegeId],
            'name_ar' => ['sometimes', 'string', 'max:255', 'unique:colleges,name_ar,' . $collegeId],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'College name already exists',
            'name_ar.unique' => 'Arabic college name already exists',
        ];
    }
}
