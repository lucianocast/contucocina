<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query();

        if ($request->filled('buscar')) {
            $term = '%'.$request->buscar.'%';
            $q->where(function ($s) use ($term) {
                $s->where('name', 'like', $term)
                  ->orWhere('email','like', $term);
            });
        }
        if ($request->filled('rol') && in_array($request->rol, ['admin','cliente'])) {
            $q->where('rol', $request->rol);
        }
        if ($request->filled('estado') && in_array($request->estado, ['activo','inactivo'])) {
            $q->where('active', $request->estado === 'activo');
        }

        $usuarios = $q->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $usuario = User::create([
            'name'   => $data['name'],
            'email'  => $data['email'],
            'password' => Hash::make($data['password']),
            'rol'   => $data['rol'],
            'active' => (bool)($data['active'] ?? true),
        ]);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(UserUpdateRequest $request, User $usuario)
    {
        $data = $request->validated();

        $usuario->name  = $data['name'];
        $usuario->email = $data['email'];
        $usuario->rol  = $data['rol'];
        $usuario->active = (bool)($data['active'] ?? false);

        if (!empty($data['password'])) {
            $usuario->password = Hash::make($data['password']);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('ok', 'Usuario actualizado.');
    }

    /**
     * Desactivar/activar sin borrar; si querés borrar real, habilitá destroy().
     */
    public function toggle(User $usuario)
    {
        // Evitar que un admin se desactive a sí mismo
        if (auth()->id() === $usuario->id) {
            return back()->with('error','No podés cambiar tu propio estado.');
        }
        $usuario->active = ! $usuario->active;
        $usuario->save();

        return back()->with('ok', 'Estado actualizado.');
    }


    public function destroy(User $usuario)
    {
        if (auth()->id() === $usuario->id) {
            return back()->with('error','No podés eliminar tu propio usuario.');
        }
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('ok', 'Usuario eliminado.');
    }
}
