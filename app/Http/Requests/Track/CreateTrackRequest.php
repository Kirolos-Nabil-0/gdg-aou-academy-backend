<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;

class CreateTrackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('Admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:tracks,name'],
            'name_ar' => ['required', 'string', 'max:255', 'unique:tracks,name_ar'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Track name is required',
            'name.unique' => 'Track name already exists',
            'name_ar.required' => 'Arabic track name is required',
            'name_ar.unique' => 'Arabic track name already exists',
        ];
    }
}
