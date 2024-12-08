<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->access === 'penjual';
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'disease_id' => 'required',
        ];
    }
}
