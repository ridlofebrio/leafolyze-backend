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
            'access' => 'required|in:petani,penjual',
            'name' => 'required|string|max:255',
            'shop_name' => 'required_if:access,penjual|string|max:255',
            'shop_address' => 'required_if:access,penjual|string|max:500',
            'shop_description' => 'required_if:access,penjual|string|max:1000',
            'shop_operational' => 'required_if:access,penjual|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'access.required' => 'Access is required',
            'access.in' => 'Access must be petani or penjual',
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must not exceed 255 characters',
            'shop_name.required_if' => 'Shop name is required for penjual access',
            'shop_name.string' => 'Shop name must be a string',
            'shop_name.max' => 'Shop name must not exceed 255 characters',
            'shop_address.required_if' => 'Shop address is required for penjual access',
            'shop_address.string' => 'Shop address must be a string',
            'shop_address.max' => 'Shop address must not exceed 500 characters',
            'shop_description.required_if' => 'Shop description is required for penjual access',
            'shop_description.string' => 'Shop description must be a string',
            'shop_description.max' => 'Shop description must not exceed 1000 characters',
            'shop_operational.required_if' => 'Shop operational is required for penjual access',
            'shop_operational.string' => 'Shop operational must be a string',
            'shop_operational.max' => 'Shop operational must not exceed 1000 characters',
        ];
    }
}
