<?php

namespace Code\Http\Requests\Tienda;

use Illuminate\Foundation\Http\FormRequest;

class TiendaProductoRequest extends FormRequest
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
            'sku' => 'required|regex:/^[a-zA-Z0-9\-]+$/|max:255',
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'contenido' => 'required',
            'precio'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'galeria' => 'required',
            'imagen' => 'required',
            'fecha_publicacion' => 'required|date_format:d/m/Y',
            'demo' => 'required|url',
            'archivo' => 'required',
            'categoria' => 'required|array|exists:tienda_categoria,id',
            'estado' => 'boolean',
        ];
    }
}
