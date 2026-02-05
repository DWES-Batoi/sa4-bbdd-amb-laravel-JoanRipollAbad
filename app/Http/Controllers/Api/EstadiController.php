<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstadiResource;
use App\Models\Estadi;
use Illuminate\Http\Request;

class EstadiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EstadiResource::collection(Estadi::with('equips')->paginate(10));
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
            'nom' => 'required|string|max:255|unique:estadis,nom',
            'capacitat' => 'required|integer|min:1000|max:100000',
        ]);

        $estadi = Estadi::create($validated);
        return response()->json($estadi, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Estadi $estadi)
    {
        return new EstadiResource($estadi->load('equips'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estadi $estadi)
    {
        if (!in_array(auth()->user()->role, ['administrador'])) {
        return response()->json([
            'success' => false,
            'message' => 'Només els administradors poden crear jugadores.',
        ], 403);
    }

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:estadis,nom,' . $estadi->id . ',id',
            'capacitat' => 'required|integer|min:1000|max:100000',
        ]);

        $estadi->update($validated);
        return response()->json($estadi->load('equips'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estadi $estadi)
    {
        if (!in_array(auth()->user()->role, ['administrador'])) {
        return response()->json([
            'success' => false,
            'message' => 'Només els administradors poden crear jugadores.',
        ], 403);
    }
    
        $estadi->delete();
        return response()->noContent();
    }
}
