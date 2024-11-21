<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'access' => 'required|in:admin,petani,penjual',
            'name' => 'required|string|max:255',
            'birth' => 'required|date',
            'gender' => 'required|string',
            'address' => 'required|string',
            'gambarUrl' => 'nullable|string',
        ];
    }
}
