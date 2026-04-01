<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vetement;
use App\Services\VetementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VetementApiController extends Controller
{
    public function __construct(
        private readonly VetementService $vetementService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->vetementService->getAll(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'couleur' => 'nullable|string|max:255',
            'saison' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $vetement = $this->vetementService->create($validated);

        return response()->json([
            'message' => 'Vetement cree avec succes.',
            'data' => $vetement,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'message' => 'Vetement recupere avec succes.',
            'data' => $this->vetementService->find($id),
        ]);
    }

    public function update(Request $request, Vetement $vetement): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'categorie' => 'sometimes|required|string|max:255',
            'couleur' => 'nullable|string|max:255',
            'saison' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $updatedVetement = $this->vetementService->update($vetement, $validated);

        return response()->json([
            'message' => 'Vetement mis a jour avec succes.',
            'data' => $updatedVetement,
        ]);
    }

    public function destroy(Vetement $vetement): JsonResponse
    {
        $this->vetementService->delete($vetement);

        return response()->json([
            'message' => 'Vetement supprime avec succes.',
        ]);
    }
}
