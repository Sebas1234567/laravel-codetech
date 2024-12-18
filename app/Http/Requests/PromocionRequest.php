<?php

namespace Code\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromocionRequest extends FormRequest
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
            'descripcion'=> 'required|max:255',
            'fechaInicio' => 'required|date_format:d/m/Y',
            'fechaFin' => 'required|date_format:d/m/Y',
            'porcentaje' => 'required|min:0|max:100',
            'imagen' => 'required',
            'estado' => 'boolean',
        ];
    }
}
