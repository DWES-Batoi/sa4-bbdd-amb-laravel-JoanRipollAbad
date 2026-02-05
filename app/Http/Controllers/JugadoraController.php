<?php

namespace App\Http\Controllers;

use App\Http\Requests\JugadoraRequest;
use App\Models\Equip;
use App\Models\Jugadora;
use App\Services\JugadoraService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JugadoraController extends Controller
{
    public function __construct(private JugadoraService $servei) {}

    public function index() {
        $jugadoras = $this->servei->llistar();
        return view('jugadoras.index', compact('jugadoras'));
    }

    public function create() {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden crear jugadores.');
        }

        $equips = Equip::all();
        return view('jugadoras.create', compact('equips'));
    }

    public function store(JugadoraRequest $request) {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden crear jugadores.');
        }

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('jugadoras', 'public');
            $data['foto'] = $path;
        }

        $this->servei->guardar($data);
        return redirect()->route('jugadoras.index')->with('success', 'Jugadora creada!');
    }

    public function show(Jugadora $jugadora) {
        $jugadora->load('equip');
        return view('jugadoras.show', compact('jugadora'));
    }

    public function edit(Jugadora $jugadora) {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden editar jugadores.');
        }

        $equips = Equip::all();
        return view('jugadoras.edit', compact('jugadora', 'equips'));
    }

    public function update(JugadoraRequest $request, Jugadora $jugadora) {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden editar jugadores.');
        }

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($jugadora->foto) {
                Storage::disk('public')->delete($jugadora->foto);
            }
            $path = $request->file('foto')->store('jugadoras', 'public');
            $data['foto'] = $path;
        }

        $this->servei->actualitzar($jugadora->id, $data);
        return redirect()->route('jugadoras.index')->with('success', 'Jugadora actualizada!');
    }

    public function destroy(Jugadora $jugadora) {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden esborrar jugadores.');
        }

        if ($jugadora->foto) {
            Storage::disk('public')->delete($jugadora->foto);
        }
        
        $this->servei->eliminar($jugadora->id);
        return redirect()->route('jugadoras.index')->with('success', 'Jugadora eliminada');
    }
}