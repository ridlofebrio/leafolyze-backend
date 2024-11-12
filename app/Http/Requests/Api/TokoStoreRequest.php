<?php

namespace App\Http\Requests\Api;

use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;

class TokoStoreRequest extends FormRequest
{
    use ImageTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'nama_toko' => 'string',
            'alamat' => 'string',
            'jam_operasional' => 'string',
            'deskripsi' => 'string',
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
            'nama_toko' => $this->input('nama_toko'),
            'alamat' => $this->input('alamat'),
            'jam_operasional' => $this->input('jam_operasional'),
            'deskripsi' => $this->input('deskripsi'),
        ];
    }
}
