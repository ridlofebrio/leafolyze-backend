<?php

namespace App\Http\Requests\Detection;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->access === 'petani';
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'disease_ids' => 'sometimes',
            'disease_ids.*' => 'exists:diseases,id'
        ];
    }

    public function messages(): array
    {
        return [
            'disease_ids.required_with' => 'Disease IDs are required when regenerating the image.',
        ];
    }
}
