<?php

namespace App\Http\Requests\Api;

use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;


class MachineLearningUpdateRequest extends FormRequest
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
            'gambarUrl'   => 'image|mimes:jpeg,png,jpg',
            'user_id' => 'exists:users,id',
            'description' => 'string'
        ];
    }


    public function getFile(){
        return [
            'gambarUrl' => $this->input('gambarUrl'),
            'user_id'   => $this->input('user_id'),
            'description' => $this->input('description'),
        ];
    }
}
