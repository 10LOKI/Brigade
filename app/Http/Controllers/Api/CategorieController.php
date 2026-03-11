<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('user_id', $request->user()->id)
                              ->with('plats')
                              ->get();

        return response()->json($categories, 200);
    }

    public function store(StoreCategorieRequest $request)
    {
        $this->authorize('create', Category::class);

        $category = Category::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message'  => 'Catégorie créée avec succès',
            'category' => $category
        ], 201);
    }

    public function show(Category $category)
    {
        $this->authorize('view', $category);
        return response()->json($category->load('plats'), 200);
    }

    public function update(UpdateCategorieRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        $category->update($request->validated());

        return response()->json([
            'message'  => 'Catégorie modifiée avec succès',
            'category' => $category
        ], 200);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ], 200);
    }

    public function associerPlats(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $request->validate([
            'plats'   => 'required|array',
            'plats.*' => 'exists:plats,id'
        ]);

        $category->plats()->syncWithoutDetaching($request->plats);

        return response()->json([
            'message'  => 'Plats associés avec succès',
            'category' => $category->load('plats')
        ], 200);
    }
}
