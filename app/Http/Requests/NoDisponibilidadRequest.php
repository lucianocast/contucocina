<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoDisponibilidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // ya restringimos por middleware de admin en rutas
    }

    public function rules(): array
    {
        $id = $this->route('no_disponible')?->id; // para update
        return [
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today',
                'unique:no_disponibilidades,fecha' . ($id ? ',' . $id : '')
            ],
            'motivo' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.after_or_equal' => 'No se pueden bloquear fechas pasadas.',
            'fecha.unique' => 'Esa fecha ya está marcada como no disponible.',
        ];
    }
}
