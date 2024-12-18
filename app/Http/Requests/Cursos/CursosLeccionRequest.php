<?php

namespace Code\Http\Requests\Cursos;

use Illuminate\Foundation\Http\FormRequest;

class CursosLeccionRequest extends FormRequest
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
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'categoria' => 'required|max:512',
            'video' => 'required|exists:cursos_video,id',
            'curso' => 'required|exists:cursos_curso,id',
            'recursos' => 'nullable',
            'estado' => 'boolean'
        ];
    }
}
