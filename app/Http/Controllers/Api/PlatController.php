<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlatRequest;
use App\Http\Requests\UpdatePlatRequest;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = Storage::disk('cloudinary')->put('plats', $request->file('image'));
            $data['image'] = $path;
        }

        $plat = Plat::create([
            ...$data,
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

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($plat->image) {
                Storage::disk('cloudinary')->delete($plat->image);
            }
            $path = Storage::disk('cloudinary')->put('plats', $request->file('image'));
            $data['image'] = $path;
        }

        $plat->update($data);

        return response()->json([
            'message' => 'Plat modifié avec succès',
            'plat'    => $plat
        ], 200);
    }

    public function destroy(Plat $plat)
    {
        $this->authorize('delete', $plat);

        if ($plat->image) {
            Storage::disk('cloudinary')->delete($plat->image);
        }

        $plat->delete();

        return response()->json([
            'message' => 'Plat supprimé avec succès'
        ], 200);
    }
}
