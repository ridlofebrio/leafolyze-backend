<?php

namespace App\Http\Requests\Detection;

use Illuminate\Foundation\Http\FormRequest;

class CreateDetectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->access === 'petani';
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'disease_ids' => 'required|array',
            'disease_ids.*' => 'exists:diseases,id'
        ];
    }
}