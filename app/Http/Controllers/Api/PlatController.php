<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlatRequest;
use App\Http\Requests\UpdatePlatRequest;
use App\Models\Plat;
use Illuminate\Http\Request;

class PlatController extends Controller
{
    public function index(Request $request)
    {
        $plats = Plat::where('user_id', $request->user()->id)->get();
        return response()->json($plats, 200);
    }

    public function store(StorePlatRequest $request)
    {
        $this->authorize('create', Plat::class);

        $plat = Plat::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Plat créé avec succès',
            'plat'    => $plat
        ], 201);
    }

    public function show(Plat $plat)
    {
        $this->authorize('view', $plat);
        return response()->json($plat, 200);
    }

    public function update(UpdatePlatRequest $request, Plat $plat)
    {
        $this->authorize('update', $plat);
        $plat->update($request->validated());

        return response()->json([
            'message' => 'Plat modifié avec succès',
            'plat'    => $plat
        ], 200);
    }

    public function destroy(Plat $plat)
    {
        $this->authorize('delete', $plat);
        $plat->delete();

        return response()->json([
            'message' => 'Plat supprimé avec succès'
        ], 200);
    }
}
