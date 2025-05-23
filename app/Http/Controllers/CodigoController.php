<?php

namespace App\Http\Controllers;

use App\Models\Codigo;
use Illuminate\Http\Request;
use Illuminate\Routing\ControllerMiddlewareOptions as Middleware;

class CodigoController extends Controller
{
    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function index()
    {
        $codigos = Codigo::all();
        return view('admin.codigos.index', compact('codigos'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function create()
    {
        return view('admin.codigos.create');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:P,L,G,MG'
        ]);

        Codigo::create($request->all());

        return redirect()->route('codigos.index')->with('success', 'Código creado exitosamente');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function edit($id)
    {
        $codigo = Codigo::findOrFail($id);
        return view('admin.codigos.edit', compact('codigo'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:P,L,G,MG'
        ]);

        $codigo = Codigo::findOrFail($id);
        $codigo->update($request->all());

        return redirect()->route('codigos.index')->with('success', 'Código actualizado exitosamente');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function destroy($id)
    {
        $codigo = Codigo::findOrFail($id);
        $codigo->delete();

        return redirect()->route('codigos.index')->with('success', 'Código eliminado exitosamente');
    }
}