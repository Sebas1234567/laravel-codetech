<?php

namespace Code\Http\Requests\Tienda;

use Illuminate\Foundation\Http\FormRequest;

class TiendaDescuentoRequest extends FormRequest
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
            'codigo' => 'required|alpha_num|max:50',
            'cantidad'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_cant' => 'nullable|in:0,1',
            'tipo' => 'required|max:20',
            'fechaInicio' => 'required|date_format:d/m/Y',
            'fechaFin' => 'required|date_format:d/m/Y',
            'productos' => 'nullable',
            'estado' => 'boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateProductoIdExists($validator);
        });
    }

    protected function validateProductoIdExists($validator)
    {
        $validator->sometimes('productos', 'array|exists:tienda_producto,id', function ($input) {
            return $input->productos !== null;
        });
    }
}
