<?php

namespace App\Http\Requests\Api;

use App\Providers\Services\Interface\Services\CloudinaryStorage;
use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class MachineLearningStoreRequest extends FormRequest
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
            'gambarUrl' => 'required|image|mimes:jpeg,png,jpg',
            'user_id' => 'required|unique:gambar,user_id',
            'deskripsi' => 'string'
        ];
    }


    protected function passedValidation(){
       $this->handleUpload();
    }

    public function getFile(){
        return [
            'gambarUrl' => $this->input('gambarUrl'),
            'user_id'   => $this->input('user_id'),
            'deskripsi' => $this->input('deskripsi'),
        ];
    }
}
