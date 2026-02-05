<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipResource;
use App\Models\Equip;
use Illuminate\Http\Request;

class EquipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EquipResource::collection(Equip::with('estadi')->paginate(10));
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
            'nom' => 'required|string|max:255|unique:equips,nom',
            'estadi_id' => 'required|exists:estadis,id',
            'titols' => 'nullable|integer|min:0',
            'escut' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $equip = Equip::create($validated);
        return response()->json($equip, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equip $equip)
    {
        return new EquipResource($equip->load('estadi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equip $equip)
    {
        if (!in_array(auth()->user()->role, ['administrador'])) {
        return response()->json([
            'success' => false,
            'message' => 'Només els administradors poden crear jugadores.',
        ], 403);
    }

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:equips,nom,' . $equip->id . ',id',
            'estadi_id' => 'required|exists:estadis,id',
            'titols' => 'nullable|integer|min:0',
            'escut' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $equip->update($validated);
        return response()->json($equip->load('estadi'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equip $equip)
    {
        if (!in_array(auth()->user()->role, ['administrador'])) {
        return response()->json([
            'success' => false,
            'message' => 'Només els administradors poden crear jugadores.',
        ], 403);
    }
    
        $equip->delete();
        return response()->noContent();
    }
}
