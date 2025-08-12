<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // rutas restringidas a admin
    }

    public function rules(): array
    {
        return [
            'name'     => ['required','string','max:120'],
            'email'    => ['required','email','max:150','unique:users,email'],
            'password' => ['required','string','min:8','max:100'],
            'rol'     => ['required', Rule::in(['admin','cliente'])],
            'active'   => ['sometimes','boolean'],
            'telefono' => ['nullable','string','max:30'],
            'direccion' => ['nullable','string','max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo',
            'password' => 'contraseña',
            'rol' => 'rol',
        ];
    }
}
