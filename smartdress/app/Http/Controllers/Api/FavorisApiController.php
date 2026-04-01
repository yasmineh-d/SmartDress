<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favoris;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavorisApiController extends Controller
{
    public function index(): JsonResponse
    {
        $favoris = Favoris::with(['vetement', 'tenue'])->get();

        return response()->json([
            'success' => true,
            'data' => $favoris,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vetement_id' => 'nullable|exists:vetements,id',
            'tenue_id' => 'nullable|exists:tenues,id',
        ]);

        if (is_null($validated['vetement_id']) && is_null($validated['tenue_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez sélectionner un vêtement ou une tenue.',
            ], 400);
        }

        $favori = Favoris::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ajouté aux favoris.',
            'data' => $favori,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $favori = Favoris::with(['vetement', 'tenue'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $favori,
        ]);
    }

    public function destroy(Favoris $favori): JsonResponse
    {
        $favori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Retiré des favoris.',
        ]);
    }
}
