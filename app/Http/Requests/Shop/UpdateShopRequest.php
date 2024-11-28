<?php

namespace App\Http\Requests\Shop;

use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->access === 'penjual';
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:500',
            'description' => 'sometimes|string|max:1000',
            'operational' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
