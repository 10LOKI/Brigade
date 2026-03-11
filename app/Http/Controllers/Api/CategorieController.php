<?php
// app/Http/Controllers/Api/CategorieController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // GET /api/categories
    public function index(Request $request)
    {
        $categories = Categorie::where('restaurant_id', $request->user()->restaurant_id)
                               ->with('plats')
                               ->get();

        return response()->json($categories, 200);
    }

    // POST /api/categories
    public function store(StoreCategorieRequest $request)
    {
        $this->authorize('create', Categorie::class);

        $categorie = Categorie::create([
            ...$request->validated(),
            'restaurant_id' => $request->user()->restaurant_id,
        ]);

        return response()->json([
            'message'    => 'Catégorie créée avec succès',
            'categorie'  => $categorie
        ], 201);
    }

    // GET /api/categories/{id}
    public function show(Categorie $categorie)
    {
        $this->authorize('view', $categorie);

        return response()->json($categorie->load('plats'), 200);
    }

    // PUT /api/categories/{id}
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        $this->authorize('update', $categorie);

        $categorie->update($request->validated());

        return response()->json([
            'message'   => 'Catégorie modifiée avec succès',
            'categorie' => $categorie
        ], 200);
    }

    // DELETE /api/categories/{id}
    public function destroy(Categorie $categorie)
    {
        $this->authorize('delete', $categorie);

        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ], 200);
    }

    // POST /api/categories/{id}/plats
    public function associerPlats(Request $request, Categorie $categorie)
    {
        $this->authorize('update', $categorie);

        $request->validate([
            'plats'   => 'required|array',
            'plats.*' => 'exists:plats,id'
        ]);

        $categorie->plats()->syncWithoutDetaching($request->plats);

        return response()->json([
            'message'   => 'Plats associés avec succès',
            'categorie' => $categorie->load('plats')
        ], 200);
    }
}