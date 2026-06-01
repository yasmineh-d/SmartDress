<?php

namespace App\Http\Controllers;

use App\Services\FavorisService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function __construct(
        private readonly FavorisService $favorisService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favoris = $this->favorisService->getForUser(Auth::user());

        return view('favoris.index', compact('favoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vetement_id' => 'nullable|exists:vetements,id',
            'tenue_id'    => 'nullable|exists:tenues,id',
        ]);

        if ($this->favorisService->existsForUser(Auth::user(), $validated)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Déjà en favoris']);
            }

            return back()->with('error', 'Déjà en favoris.');
        }

        $favori = $this->favorisService->createForUser(Auth::user(), $validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'id' => $favori->id]);
        }

        return back()->with('success', 'Ajouté aux favoris.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $this->favorisService->deleteForUser((int) $id, Auth::user());
        } catch (AuthorizationException) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            abort(403);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Retiré des favoris.');
    }
}
