<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('Admin');
    }

    public function rules(): array
    {
        $trackId = $this->route('id');

        return [
            'name' => ['sometimes', 'string', 'max:255', 'unique:tracks,name,' . $trackId],
            'name_ar' => ['sometimes', 'string', 'max:255', 'unique:tracks,name_ar,' . $trackId],
            'description' => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Track name already exists',
            'name_ar.unique' => 'Arabic track name already exists',
        ];
    }
}
