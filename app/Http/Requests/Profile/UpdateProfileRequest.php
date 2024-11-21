<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore($this->user()->id)
            ],
            'name' => 'sometimes|string|max:255',
            'birth' => 'sometimes|date',
            'gender' => 'sometimes|in:male,female',
            'address' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
