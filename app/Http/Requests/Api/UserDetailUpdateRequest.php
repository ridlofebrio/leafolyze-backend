<?php

namespace App\Http\Requests\Api;

use App\Trait\ImageTrait;
use Illuminate\Foundation\Http\FormRequest;

class UserDetailUpdateRequest extends FormRequest
{
    use ImageTrait;

    private $id;

    protected function passedValidation()
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
            'user_id'    => 'required|exists:users,id',
            'name'       => 'required|string|max:255',
            'birth'      => 'nullable',
            'gender'     => 'required',
            'address'    => 'nullable|string|max:500',
            'gambarUrl'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Get the validated data for model assignment.
     *
     * @return array<string, mixed>
     */
    public function getFile(): array
    {
        return [
            'user_id'   => $this->input('user_id'),
            'name'      => $this->input('name'),
            'birth'     => $this->input('birth'),
            'gender'    => $this->input('gender'),
            'address'   => $this->input('address'),
            'gambarUrl' => $this->input('gambarUrl'),
        ];
    }
}
