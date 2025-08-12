<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $id = $this->route('usuario')?->id; // /admin/usuarios/{usuario}

        return [
            'name'     => ['required','string','max:120'],
            'email'    => ['required','email','max:150','unique:users,email,'.($id ?? 'NULL').',id'],
            'password' => ['nullable','string','min:8','max:100'], // si viene, se cambia
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

    public function messages(): array
    {
        return [
            'rol.required' => 'El campo rol es obligatorio.',
            'rol.in' => 'El valor seleccionado para rol no es válido.',
        ];
    }
}
