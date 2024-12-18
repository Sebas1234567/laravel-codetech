<?php

namespace Code\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogEntradasRequest extends FormRequest
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
            'imagen' => 'required|max:512',
            'descripcion' => 'required',
            'contenido' => 'required',
            'fecha_publicacion' => 'required|date_format:d/m/Y',
            'idvideo' => 'required|exists:blog_video,id',
            'idautor' => 'required|exists:blog_autor,id',
            'idcategoria' => 'required|array|exists:blog_categoria,id',
            'estado' => 'boolean',
        ];
    }
}
