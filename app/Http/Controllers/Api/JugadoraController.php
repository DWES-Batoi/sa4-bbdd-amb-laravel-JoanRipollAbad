<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JugadoraResource;
use App\Models\Jugadora;
use Illuminate\Http\Request;

class JugadoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return JugadoraResource::collection(Jugadora::with('equip')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    if (!in_array(auth()->user()->role, ['administrador'])) {
        return response()->json([
            'success' => false,
            'message' => 'Només els administradors poden crear jugadores.',
        ], 403);
    }

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'equip_id' => 'required|exists:equips,id',
        'posicio' => 'nullable|string|max:100',
        'dorsal' => 'nullable|integer|min:0|max:99',
        'data_naixement' => 'nullable|date', 
    ]);

    $jugadora = Jugadora::create($validated);
    return response()->json($jugadora, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Jugadora $jugadora)
    {
        return new JugadoraResource($jugadora->load('equip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jugadora $jugadora)
{
    if (!in_array(auth()->user()->role, ['administrador'])) {
        return response()->json([
            'success' => false,
            'message' => 'Només els administradors poden crear jugadores.',
        ], 403);
    }

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'equip_id' => 'required|exists:equips,id',
        'posicio' => 'nullable|string|max:100',
        'dorsal' => 'nullable|integer|min:0|max:99',
        'data_naixement' => 'nullable|date',
    ]);

    $jugadora->update($validated);
    return response()->json($jugadora, 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jugadora $jugadora)
{
    if (!in_array(auth()->user()->role, ['administrador'])) {
        return response()->json([
            'success' => false,
            'message' => 'Només els administradors poden crear jugadores.',
        ], 403);
    }
    
    $jugadora->delete();
    return response()->noContent();
}
}
