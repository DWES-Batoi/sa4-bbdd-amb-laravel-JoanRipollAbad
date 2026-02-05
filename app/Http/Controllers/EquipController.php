<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use App\Models\Equip;
use App\Models\Estadi;
use App\Services\EquipService;
use Illuminate\Support\Facades\Auth;

class EquipController extends Controller
{
    public function __construct(private EquipService $servei) {}

    // GET /equips
    public function index() {
        $equips = $this->servei->llistar();
        return view('equips.index', compact('equips'));
    }

    // GET /equips/create
    public function create() {
        // Comprova que l'usuari sigui administrador
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden crear equips.');
        }

        $estadis = Estadi::all();
        return view('equips.create', compact('estadis'));
    }

    // POST /equips
    public function store(StoreEquipRequest $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden crear equips.');
        }

        $this->servei->guardar($request->validated(), $request->file('escut'));
        return redirect()->route('equips.index')
            ->with('success', 'Equip creat correctament!');
    }

    // GET /equips/{equip}
    public function show(Equip $equip) {
        return view('equips.show', compact('equip'));
    }

    // GET /equips/{id}/edit
    public function edit(Equip $equip) {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden editar equips.');
        }

        $estadis = Estadi::all();
        return view('equips.edit', compact('equip', 'estadis'));
    }

    // PUT /equips/{equip}
    public function update(UpdateEquipRequest $request, Equip $equip)
    {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden editar equips.');
        }

        $this->servei->actualitzar($equip->id, $request->validated(), $request->file('escut'));
        return redirect()->route('equips.index')->with('success', 'Equip actualitzat correctament!');
    }

    // DELETE /equips/{equip}
    public function destroy(Equip $equip) {
        if (!Auth::check() || Auth::user()->role !== 'administrador') {
            abort(403, 'Només els administradors poden esborrar equips.');
        }

        $this->servei->eliminar($equip->id);
        return redirect()->route('equips.index');
    }
}