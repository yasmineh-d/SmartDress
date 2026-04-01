<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TenueApiController extends Controller
{
    public function index(): JsonResponse
    {
        $tenues = Tenue::with('vetements')->get();

        return response()->json([
            'success' => true,
            'data' => $tenues,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'meteo_adaptee' => 'nullable|string',
            'conseil_ia' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'vetements' => 'nullable|array',
            'vetements.*' => 'exists:vetements,id',
        ]);

        $tenue = Tenue::create($validated);

        if ($request->has('vetements')) {
            $tenue->vetements()->sync($request->vetements);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tenue créée avec succès.',
            'data' => $tenue->load('vetements'),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $tenue = Tenue::with('vetements')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $tenue,
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

        $tenue->update($validated);

        if ($request->has('vetements')) {
            $tenue->vetements()->sync($request->vetements);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tenue mise à jour avec succès.',
            'data' => $tenue->load('vetements'),
        ]);
    }

    public function destroy(Tenue $tenue): JsonResponse
    {
        $tenue->vetements()->detach();
        $tenue->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tenue supprimée avec succès.',
        ]);
    }
}
