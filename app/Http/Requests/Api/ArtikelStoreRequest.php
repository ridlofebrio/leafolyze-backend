<?php

namespace App\Http\Requests\Api;

use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;

class ArtikelStoreRequest extends FormRequest
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
            'judul' => 'required|string',
            'konten' => 'required|string',
            'durasi_baca' => 'required',
            'gambarUrl' => 'required|image|mimes:jpeg,png,jpg',
            'user_id' => 'required|exists:users,id',
        ];
    }

    protected function passedValidation(){
        $this->handleUpload();
    }

    public function getFile()
    {
        return [
            'judul' => $this->input('judul'),
            'konten' => $this->input('konten'),
            'durasi_baca' => $this->input('durasi_baca'),
            'gambarUrl' => $this->input('gambarUrl'),
            'user_id' => $this->input('user_id'),
        ];
    }
}
