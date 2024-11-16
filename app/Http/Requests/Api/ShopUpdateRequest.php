<?php

namespace App\Http\Requests\Api;

use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;

class ShopUpdateRequest extends FormRequest
{

    use ImageTrait;
    private $id;protected function passedValidation()

{
    $this->id = $this->route('id');
    $this->handleUpload($this->id);
}

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'name' => 'string',
            'address' => 'string',
            'operational' => 'string',
            'description' => 'string',
        ];
    }

    public function getFile()
    {
        return [
            'gambarUrl' => $this->input('gambarUrl'),
            'user_id' => $this->input('user_id'),
            'name' => $this->input('name'),
            'address' => $this->input('address'),
            'operational' => $this->input('operational'),
            'description' => $this->input('description'),
        ];
    }
}
