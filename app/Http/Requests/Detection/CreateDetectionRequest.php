<?php

namespace App\Http\Requests\Detection;

use Illuminate\Foundation\Http\FormRequest;

class CreateDetectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            //TODO : add array of disease_ids
            'disease_ids' => 'required',
            'disease_ids.*' => 'exists:diseases,id'
        ];
    }
}
