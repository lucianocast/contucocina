<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoDisponibilidadRequest;
use App\Models\NoDisponibilidad;

class NoDisponibilidadController extends Controller
{
    public function index()
    {
        $items = NoDisponibilidad::orderBy('fecha', 'desc')->paginate(20);
        return view('admin.no_disponibles.index', compact('items'));
    }

    public function create()
    {
        return view('admin.no_disponibles.create');
    }

    public function store(NoDisponibilidadRequest $request)
    {
        NoDisponibilidad::create($request->validated());
        return redirect()->route('no-disponibles.index')->with('ok', 'Fecha no disponible agregada.');
    }

    public function edit(NoDisponibilidad $no_disponible)
    {
        return view('admin.no_disponibles.edit', compact('no_disponible'));
    }

    public function update(NoDisponibilidadRequest $request, NoDisponibilidad $no_disponible)
    {
        $no_disponible->update($request->validated());
        return redirect()->route('no-disponibles.index')->with('ok', 'Fecha no disponible actualizada.');
    }

    public function destroy(NoDisponibilidad $no_disponible)
    {
        $no_disponible->delete();
        return back()->with('ok', 'Fecha no disponible eliminada.');
    }
}
