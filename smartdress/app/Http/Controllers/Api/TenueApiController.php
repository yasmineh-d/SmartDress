<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenue;
use App\Services\TenueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TenueApiController extends Controller
{
    public function __construct(
        private readonly TenueService $tenueService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->tenueService->getForUser($request->user())->load('vetements'),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'meteo_adaptee' => 'nullable|string',
            'conseil_ia' => 'nullable|string',
            'vetements' => 'nullable|array',
            'vetements.*' => 'exists:vetements,id',
        ]);

        $tenue = $this->tenueService->createForUser($request->user(), $validated);

        return response()->json([
            'success' => true,
            'message' => 'Tenue créée avec succès.',
            'data' => $tenue,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->tenueService->findWithClothes($id),
        ]);
    }

    public function update(Request $request, Tenue $tenue): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'meteo_adaptee' => 'nullable|string',
            'conseil_ia' => 'nullable|string',
            'vetements' => 'nullable|array',
            'vetements.*' => 'exists:vetements,id',
        ]);

        $updatedTenue = $this->tenueService->update($tenue, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Tenue mise à jour avec succès.',
            'data' => $updatedTenue,
        ]);
    }

    public function destroy(Tenue $tenue): JsonResponse
    {
        $this->tenueService->delete($tenue);

        return response()->json([
            'success' => true,
            'message' => 'Tenue supprimée avec succès.',
        ]);
    }
}
