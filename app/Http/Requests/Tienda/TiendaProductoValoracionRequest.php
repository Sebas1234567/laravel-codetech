<?php

namespace Code\Http\Requests\Tienda;

use Illuminate\Foundation\Http\FormRequest;

class TiendaProductoValoracionRequest extends FormRequest
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
            'usuario' => 'required|exists:users,id',
            'fecha_publicacion' => 'required|date_format:d/m/Y',
            'puntuacion' => 'required|max_digits:1|max:5',
            'comentario' => 'required|max:2048',
            'producto'=> 'required|exists:tienda_producto,id',
        ];
    }
}
