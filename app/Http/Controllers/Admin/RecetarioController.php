<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecetarioRequest;
use App\Models\Recetario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecetarioController extends Controller
{
    public function index(Request $request)
    {
        $q = Recetario::query();

        if ($request->filled('categoria')) {
            $q->where('categoria', $request->categoria);
        }
        if ($request->filled('buscar')) {
            $term = '%'.$request->buscar.'%';
            $q->where(function($s) use ($term) {
                $s->where('nombre','like',$term)
                  ->orWhere('categoria','like',$term);
            });
        }

        $files = $q->orderByDesc('created_at')->paginate(20)->withQueryString();
        $categorias = Recetario::select('categoria')
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('admin.recetario.index', compact('files','categorias'));
    }

    public function store(RecetarioRequest $request)
    {
        $path = $request->file('archivo')->store('recetario'); // storage/app/recetario

        Recetario::create([
            'nombre'    => $request->nombre,
            'categoria' => $request->categoria ?: null,
            'path'      => $path,
            'user_id'   => auth()->id(),
        ]);

        return back()->with('ok','Archivo subido correctamente.');
    }

    public function download($id)
    {
        $rec = Recetario::findOrFail($id);
        $ext = pathinfo($rec->path, PATHINFO_EXTENSION) ?: 'dat';
        return Storage::download($rec->path, $rec->nombre.'.'.$ext);
    }

    public function destroy($id)
    {
        $rec = Recetario::findOrFail($id);
        Storage::delete($rec->path);
        $rec->delete();

        return back()->with('ok','Archivo eliminado.');
    }
}
