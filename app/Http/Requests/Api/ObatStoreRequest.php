<?php

namespace App\Http\Requests\Api;

use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;

class ObatStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    use ImageTrait;
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gambarUrl' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg',
            ],
            'shop_id' => [
                'required',
                'exists:users,id',
            ],
            'description' => 'string',
            'name' => 'string',
            'price' => 'string',
            'type' => 'string',
        ];
    }
    protected function passedValidation(){
        $this->handleUpload();
    }

    public function getFile()
    {
        return [
            'gambarUrl' => $this->input('gambarUrl'),
            'shop_id' => $this->input('shop_id'),
            'description' => $this->input('description'),
            'name' => $this->input('name'),
            'price' => $this->input('price'),
            'type' => $this->input('type'),
        ];
    }
}
