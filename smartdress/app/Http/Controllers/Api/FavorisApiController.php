<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favoris;
use App\Services\FavorisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavorisApiController extends Controller
{
    public function __construct(
        private readonly FavorisService $favorisService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->favorisService->getAllWithRelations(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vetement_id' => 'nullable|exists:vetements,id',
            'tenue_id' => 'nullable|exists:tenues,id',
        ]);

        if (!$this->favorisService->hasTarget($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez sélectionner un vêtement ou une tenue.',
            ], 400);
        }

        $favori = $this->favorisService->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ajouté aux favoris.',
            'data' => $favori,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->favorisService->findWithRelations($id),
        ]);
    }

    public function destroy(Favoris $favori): JsonResponse
    {
        $this->favorisService->delete($favori);

        return response()->json([
            'success' => true,
            'message' => 'Retiré des favoris.',
        ]);
    }
}
