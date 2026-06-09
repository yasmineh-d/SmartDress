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

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->favorisService->getForUser($request->user()),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vetement_id' => 'nullable|exists:vetements,id',
            'tenue_id' => 'nullable|exists:tenues,id',
        ]);

        if (!$this->favorisService->hasTarget($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez sélectionner un vêtement ou une tenue.',
            ], 400);
        }

        if ($this->favorisService->existsForUser($request->user(), $validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Déjà en favoris.',
            ], 400);
        }

        $favori = $this->favorisService->createForUser($request->user(), $validated);

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
