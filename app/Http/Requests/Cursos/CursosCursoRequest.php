<?php

namespace Code\Http\Requests\Cursos;

use Illuminate\Foundation\Http\FormRequest;

class CursosCursoRequest extends FormRequest
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
            'slug' => 'required|max:255',
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'contenido' => 'required',
            'certificado' => 'required|boolean',
            'precio'=> 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'idcategoria' => 'required|exists:cursos_categoria,id',
            'imagen' => 'required',
            'fecha_publicacion' => 'required|date_format:d/m/Y',
            'estado' => 'boolean',
        ];
    }
}
