<?php

namespace Code\Http\Requests\Tienda;

use Illuminate\Foundation\Http\FormRequest;

class TiendaGiftcardRequest extends FormRequest
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
            'codigo' => 'required|max:50',
            'saldo'=> 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'valor' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'nota' => 'nullable|max:512',
            'usado' => 'boolean',
            'estado' => 'boolean',
        ];
    }
}
