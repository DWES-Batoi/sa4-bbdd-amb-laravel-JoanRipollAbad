<?php

namespace App\Http\Controllers;

use App\Models\Estadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstadiController extends Controller
{
    // GET /estadis
    public function index()
    {
        $estadis = Estadi::all();
        return view('estadis.index', compact('estadis'));
    }

    // GET /estadis/{estadi}
    public function show(Estadi $estadi)
    {
        $estadi->load('equips');
        return view('estadis.show', compact('estadi'));
    }

    // GET /estadis/create
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden crear estadis.');
        }

        return view('estadis.create');
    }

    // POST /estadis
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden crear estadis.');
        }

        $estadi = new Estadi($request->all());
        $estadi->save();

        return redirect()
            ->route('estadis.index')
            ->with('success', 'Estadi afegit correctament!');
    }

    // GET /estadis/{estadi}/edit
    public function edit(Estadi $estadi)
    {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden editar estadis.');
        }

        return view('estadis.edit', compact('estadi'));
    }

    // PUT/PATCH /estadis/{estadi}
    public function update(Request $request, Estadi $estadi)
    {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden editar estadis.');
        }

        $estadi->update($request->all());

        return redirect()
            ->route('estadis.index')
            ->with('success', 'Estadi actualitzat correctament!');
    }

    // DELETE /estadis/{estadi}
    public function destroy(Estadi $estadi)
    {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden esborrar estadis.');
        }

        $estadi->delete();

        return redirect()
            ->route('estadis.index')
            ->with('success', 'Estadi esborrat correctament!');
    }
}