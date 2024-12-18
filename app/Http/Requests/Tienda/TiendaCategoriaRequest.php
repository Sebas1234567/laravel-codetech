<?php

namespace Code\Http\Requests\Tienda;

use Illuminate\Foundation\Http\FormRequest;

class TiendaCategoriaRequest extends FormRequest
{
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
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'estado' => 'boolean',
            'padre_id' => 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validatePadreIdExists($validator);
        });
    }

    protected function validatePadreIdExists($validator)
    {
        $validator->sometimes('padre_id', 'exists:blog_categoria,id', function ($input) {
            return $input->padre_id !== null;
        });
    }
}
