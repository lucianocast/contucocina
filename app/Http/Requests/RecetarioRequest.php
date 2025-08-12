<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecetarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // en rutas limitamos a admin
    }

    public function rules(): array
    {
        return [
            'nombre'    => ['required','string','max:150'],
            'categoria' => ['nullable','string','max:80'],
            'archivo'   => ['required','file','max:10240'], // 10MB
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'    => 'nombre',
            'categoria' => 'categoría',
            'archivo'   => 'archivo',
        ];
    }
}
