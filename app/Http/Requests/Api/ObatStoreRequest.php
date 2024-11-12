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
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'deskripsi' => 'string',
            'namaObat' => 'string',
            'harga' => 'string',
            'jenis' => 'string',
        ];
    }
    protected function passedValidation(){
        $this->handleUpload();
    }

    public function getFile()
    {
        return [
            'gambarUrl' => $this->input('gambarUrl'),
            'user_id' => $this->input('user_id'),
            'deskripsi' => $this->input('deskripsi'),
            'namaObat' => $this->input('namaObat'),
            'harga' => $this->input('harga'),
            'jenis' => $this->input('jenis'),
        ];
    }
}
